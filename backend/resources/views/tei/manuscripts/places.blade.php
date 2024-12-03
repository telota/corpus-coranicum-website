<?xml version="1.0" encoding="UTF-8"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://relaxng.org/ns/structure/1.0"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://purl.oclc.org/dsdl/schematron"?>
<TEI xmlns="http://www.tei-c.org/ns/1.0">
    <teiHeader>
        <fileDesc>
            <titleStmt>
                <title>Authority file for Manuscript places</title>
            </titleStmt>
            <publicationStmt>
                <publisher>Corpus Coranicum</publisher>
                @foreach ($data as $place)
                    @if(!empty($place['image_copyrights']))
                    <availability xml:id="imageRights_{{$place['id']}}">
                        <licence>{{$place['image_copyrights']}}.</licence>
                    </availability>
                    @endif
                @endforeach
            </publicationStmt>
            <sourceDesc>
                <p>Information about places where manuscripts are held. Derived from CCdbSQL data dump</p>
            </sourceDesc>
        </fileDesc>
        @include('tei.templates.encoding')
    </teiHeader>
    <text>
        <body>
            <list>
                @forelse ($data as $place)
                <item xml:id="repository_{{ $place['id'] }}">
                    <title key="geoname_{{ $place['geonames_id'] }}">{{ $place['place_name'] }}</title>
                    <address>
                        <settlement>{{ $place['place'] }}</settlement>
                        @if(!empty( $place['place_iso3166_2'] ))
                        <country>{{ $place['place_iso3166_2'] }}</country>
                        @endif
                    </address>
                    @if(!empty( $place['place_description'] ))
                    <note>{{ $place['place_description'] }}</note>
                    @endif
                    @if(( $place['place_longitude'] != 0 ) && ( $place['place_latitude'] != 0 ))
                    <geo>{{ $place['place_longitude'] }} {{ $place['place_latitude'] }}</geo>
                    @endif
                    @if(!empty( $place['url'] ))
                    <ref target="{{ $place['url'] }}">{{ $place['url'] }}</ref>
                    @endif
                    @if(!empty( $place['image_url'] ))
                    <graphic url="{{ $place['image_url'] }}"
                    @if(!empty($place['image_copyrights']))
                        decls="#{{$place['image_copyrights']}}"
                    @endif
                    >
                        <desc>#imageRights_{{ $place['id'] }}</desc>
                    </graphic>
                    @endif
                </item>
                @empty
                no data
                @endforelse
            </list>
        </body>
    </text>
</TEI>
