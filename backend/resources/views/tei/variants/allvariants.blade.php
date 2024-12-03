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
            @include('tei.templates.publisher')
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
                @forelse ($data as $variant)<item xml:id="variant_{{ $variant['id'] }}">
                    @forelse ($variant['readers'] as $person)<persName key="variantreader_{{ $person['id'] }}">{{ $person['anzeigename'] }}</persName>@empty @endforelse<title key="variantsource_{{ $variant['sources']['id'] ?? '' }}">{{ $variant['sources']['anzeigetitel'] ?? '' }}</title>
                    <ab>
                        @forelse ($variant['variants'] as $keyvariant=>$readingvariant)@if (!empty($readingvariant['variante']))<w n="{{ str_pad($variant['sura'], 3, 0, STR_PAD_LEFT) }}:{{ str_pad($variant['verse'], 3, 0, STR_PAD_LEFT) }}:{{ str_pad($readingvariant['wort'], 3, 0, STR_PAD_LEFT) }}">{{ $readingvariant['variante'] }}
                            <w xml:lang="ara">{{ $variant['quran'][$keyvariant]['arab'] ?? '' }}</w>
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
