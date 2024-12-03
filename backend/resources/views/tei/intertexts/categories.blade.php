<?xml version="1.0" encoding="UTF-8"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://relaxng.org/ns/structure/1.0"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://purl.oclc.org/dsdl/schematron"?>
<TEI xmlns="http://www.tei-c.org/ns/1.0">
    <teiHeader>
        <fileDesc>
            <titleStmt>
                <title>Taxonomy der Kategorien der Umwelttexte/Belegstellen</title>
                @include('tei.templates.respStmt')
            </titleStmt>
            @include('tei.templates.publisher')
            <sourceDesc>
                <p>Information about the various categories for texts predating the Qur'an. Derived from CCdbSQL data
                    dump</p>
            </sourceDesc>
            @include('tei.templates.encoding')
        </fileDesc>
        <encodingDesc>
            <classDecl>
                <taxonomy xml:id="tuk.cat">
                    @forelse ($data as $category)
                    <category xml:id="tuk.cat.{{ $category['classification'] }}">
                        <catDesc>{{ $category['name'] }}</catDesc>

                        @forelse ($category['subcategories'] as $subcategory)
                        <category xml:id="tuk.cat.{{ $subcategory['classification'] }}">
                            <catDesc>{{ $subcategory['name'] }}</catDesc>
                        </category>
                        @empty
                        @endforelse
                    </category>
                    @empty
                    @endforelse
                </taxonomy>
            </classDecl>
        </encodingDesc>
    </teiHeader>
    <text>
        <body>
            <div></div>
        </body>
    </text>
</TEI>
