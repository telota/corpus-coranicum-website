<?xml version="1.0" encoding="UTF-8"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://relaxng.org/ns/structure/1.0"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://purl.oclc.org/dsdl/schematron"?>
<TEI xmlns="http://www.tei-c.org/ns/1.0">
    <teiHeader>
        <fileDesc>
            <titleStmt>
                <title>Authority file for readings</title>
                @include('tei.templates.respStmt')
            </titleStmt>
            <publicationStmt>
                <p>Corpus Coranicum</p>
            </publicationStmt>
            <sourceDesc>
                <p>data prepared by Corpus Coranicum
                    <ref>https://corpuscoranicum.de/api/xmltei/variants</ref>
                </p>
            </sourceDesc>
        </fileDesc>
        @include('tei.templates.encoding') 
    </teiHeader>
    <text>
        <body>
            <list>
                @forelse ($readings as $reading)<item xml:id="lesart_{{ $reading['id'] }}">
                    @forelse ($reading['readers'] as $person)<persName key="l_{{ $person['id'] }}">{{ $person['anzeigename'] }}</persName>@empty @endforelse<title key="q_{{ $reading['sources']['id'] ?? '' }}">{{ $reading['sources']['anzeigetitel'] ?? '' }}</title>
                    <ab>
                        @forelse ($reading['variants'] as $variant)@if (!empty($variant['variante']))<w n="{{ str_pad($sura, 3, 0, STR_PAD_LEFT) }}:{{ str_pad($verse, 3, 0, STR_PAD_LEFT) }}:{{ str_pad($variant['wort'], 3, 0, STR_PAD_LEFT) }}">{{ $variant['variante'] }}
                            <w xml:lang="ara">??</w>
                        </w>@endif @empty @endforelse
                    </ab>
                </item>
                @empty
                no variants found
                @endforelse
            </list>
        </body>
    </text>
</TEI>
