<?xml version="1.0" encoding="UTF-8"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://relaxng.org/ns/structure/1.0"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://purl.oclc.org/dsdl/schematron"?>
<TEI xmlns="http://www.tei-c.org/ns/1.0">
    <teiHeader>
        <fileDesc>
            <titleStmt>
                <title>Authority list of readers</title>
                @include('tei.templates.respStmt')
            </titleStmt>
            @include('tei.templates.publisher')
            <sourceDesc>
                <p>data prepared by Corpus Coranicum
                    <ref>https://telota-webpublic.bbaw.de/ccdb_edit/leser/index</ref>
                </p>
            </sourceDesc>
        </fileDesc>
        @include('tei.templates.encoding')
    </teiHeader>
    <text>
        <body>
            <listPerson>
                @forelse ($data as $person)
                <person xml:id="variantsreader_{{$person['id']}}">
                    <name type="main">{{$person['name']}}</name>
                    <name type="display">{{$person['name_display']}}</name>
                    <name xml:lang="ara" />
                    @if(!empty($person['location']))
                    <residence>{{ $person['location']}}</residence>
                    @else
                    <residence />
                    @endif
                    <note type="sigle">{{$person['sigle']}}</note>{{-- <birth/> is missing in db--}}
                    @if(!empty($person['date_of_death']))
                    <death>{{ $person['date_of_death']}}</death>
                    @else
                    <death />
                    @endif
                    @if(!empty($person['comment']))
                    <note>{{ $person['comment']}}</note>
                    @else
                    <note />
                    @endif
                </person>
                @empty
                @endforelse
            </listPerson>
        </body>
    </text>
</TEI>
