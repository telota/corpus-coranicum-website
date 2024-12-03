<?xml version="1.0" encoding="UTF-8"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://relaxng.org/ns/structure/1.0"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://purl.oclc.org/dsdl/schematron"?>
<TEI xmlns="http://www.tei-c.org/ns/1.0">
    <teiHeader>
        <fileDesc>
            <titleStmt>
                <title>Authority file for sources of readings</title>
                @include('tei.templates.respStmt')
            </titleStmt>
            @include('tei.templates.publisher')
            <sourceDesc>
                <p>Information about the source of readings
                    <ref>https://corpuscoranicum.de/api/xmltei/variants/sources</ref>
                </p>
            </sourceDesc>
        </fileDesc>
        @include('tei.templates.encoding')
    </teiHeader>
    <text>
        <body>
            <listBibl>
                @forelse ($data as $source)
                <biblStruct xml:id="variantssource_{{ $source['id']}}">
                    <monogr>
                        <author {{-- key="person_???28506598" --}}>
                            <persName>{{ $source['title_display']}}</persName>
                            <persName type="variant">{{ $source['author_long']}}</persName>
                        </author>
                        <title {{-- key="work_???175050429" --}}>{{ $source['source_arabic']}}</title>
                        <imprint>
                            <date></date>
                        </imprint>
                    </monogr>
                </biblStruct>
                @empty
                @endforelse
            </listBibl>
        </body>
    </text>
</TEI>
