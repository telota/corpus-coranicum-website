<teiHeader>
    <fileDesc>
        <titleStmt>
            <title>{{ $manuscript->archive->place .', '.$manuscript->archive->place_name .', '.$manuscript->call_number}}</title>
            <funder>Corpus Coranicum (BBAW)</funder>
            @include('tei.templates.respStmt')
        </titleStmt>
        <publicationStmt>
            <publisher>Corpus Coranicum</publisher>
            <pubPlace>
                <address>
                    <orgName>Berlin-Brandenburgische Akademie der Wissenschaften</orgName>
                    <street>Jägerstraße 22/23</street>
                    <postCode>10117</postCode>
                    <addrLine>
                        <ref target="https://corpuscoranicum.de/">Corpus Coranicum</ref>
                    </addrLine>
                    <addrLine>
                        <email>corpuscoranicum@bbaw.de</email>
                    </addrLine>
                    <settlement type="city">Berlin</settlement>
                    <country key="de">Germany</country>
                </address>
            </pubPlace>
            @foreach($image_credits as $index=>$credit)
            <availability xml:id="imageRights-{{$index+1}}" status="restricted" default="false">
                <p>Image credits: {{$credit}}.</p>
            </availability>
            @endforeach
        </publicationStmt>
        <sourceDesc>
            <msDesc xml:lang="en">
                <msIdentifier>
                    @if ($manuscript->archive)
                    <repository key="{{ $manuscript->archive->id }}">{{ $manuscript->archive->place_name }}, {{ $manuscript->archive->place }}</repository>
                    @endif
                    <idno>{{ $manuscript->call_number }}</idno>
                </msIdentifier>
                <msContents>
                    <summary>
                        {!! App\Helpers\TEI::htmlToTei($manuscript->catalogue_entry ) !!}
                    </summary>
                    @foreach ($manuscript->pages as $page)
                    @foreach ($page->passages as $passage)
                    <msItem xml:id="mysql_id_{{ $passage->id }}" n="{{ $page->folio . $page->page_side }}">
                        <title type="numeric" key="{{ str_pad($passage->sura_start, 3, '0', STR_PAD_LEFT) .
                                        ':' .
                                        str_pad($passage->verse_start, 3, '0', STR_PAD_LEFT) .
                                        ':' .
                                        str_pad($passage->word_start, 3, '0', STR_PAD_LEFT) .
                                        '-' .
                                        str_pad($passage->sura_end, 3, '0', STR_PAD_LEFT) .
                                        ':' .
                                        str_pad($passage->verse_end, 3, '0', STR_PAD_LEFT) .
                                        ':' .
                                        str_pad($passage->word_end, 3, '0', STR_PAD_LEFT) }}">
                            {{ str_pad($passage->sura_start, 3, '0', STR_PAD_LEFT) .
                                        ':' .
                                        str_pad($passage->verse_start, 3, '0', STR_PAD_LEFT) .
                                        ':' .
                                        str_pad($passage->word_start, 3, '0', STR_PAD_LEFT) .
                                        '-' .
                                        str_pad($passage->sura_end, 3, '0', STR_PAD_LEFT) .
                                        ':' .
                                        str_pad($passage->verse_end, 3, '0', STR_PAD_LEFT) .
                                        ':' .
                                        str_pad($passage->word_end, 3, '0', STR_PAD_LEFT) }}
                        </title>
                    </msItem>
                    @endforeach
                    @endforeach
                </msContents>
                <physDesc>
                    <objectDesc>
                        <supportDesc material="{{ strtolower($manuscript->writing_surface) }}">
                            @if (strlen(trim(strip_tags($manuscript->codicology))) > 0)
                            <support>
                                {!! App\Helpers\TEI::htmlToTei($manuscript->codicology) !!}
                            </support>
                            @endif
                        @php
                            $dim = explode("x", $manuscript->dimensions)
                        @endphp
                        @if(isset($manuscript->dimensions))
                          <extent>Folios: {{ $manuscript->number_of_folios }}
                            <dimensions unit="mm">
                                <width>{{trim($dim[0])}}</width>
                                <height>{{trim($dim[1])}}</height>
                            </dimensions>
                          </extent>
                        @endif
                        </supportDesc>
                        <layoutDesc>
                            @php
                             $lines = $manuscript->number_of_lines;
                             if(isset($lines)){
                                 $parsed = explode(" - ", $lines);
                                 if($parsed[0] === $parsed[1]){
                                     $lines = $parsed[0];
                                 }
                             }
                            @endphp
                            <layout writtenLines="{{ $lines }}"></layout>
                        </layoutDesc>
                    </objectDesc>
                    <handDesc>
                        <handNote></handNote>
                    </handDesc>
                    <scriptDesc>
                        @if (strlen(trim(strip_tags($manuscript->paleography))) > 0)
                        <summary>
                            {!! App\Helpers\TEI::htmlToTei($manuscript->paleography) !!}
                        </summary>
                        @endif
                        @if (strlen(trim(strip_tags($manuscript->script_styles))) > 0)
                        <scriptNote>
                            @php $scripts = $manuscript->script_styles->pluck('style')->implode(", "); @endphp
                            {{$scripts}}
                        </scriptNote>
                        @endif
                    </scriptDesc>
                </physDesc>
                <history>
                    <origin>
                        <origDate>{{ $manuscript->date_start }}{{ (!empty($manuscript->date_end) ? '-'.$manuscript->date_end : '')}}</origDate>
                    </origin>
                    @php $provenances = $manuscript->provenances->pluck('provenance')->implode(", "); @endphp
                    @if($provenances !== "")
                    <provenance>
                        {{ $provenances }}
                    </provenance>
                    @endif
                </history>
                <additional>
                    <adminInfo>
                        <recordHist>
                            @forelse($manuscript->authorRoles as $key => $author)
                            <p>{{$author->role->role_name }}: {{$author->author->author_name }}</p>
                            @empty
                            <p></p>
                            @endforelse
                        </recordHist>
                        <availability>
                            <p />
                        </availability>
                    </adminInfo>
                </additional>
            </msDesc>
        </sourceDesc>
    </fileDesc>
</teiHeader>
