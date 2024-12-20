<?xml version="1.0" encoding="UTF-8"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://relaxng.org/ns/structure/1.0"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://purl.oclc.org/dsdl/schematron"?>

<TEI xmlns="http://www.tei-c.org/ns/1.0" xml:id="{{ 'mysql_id_' . $manuscript->id }}">
    @include('tei.manuscripts.header')
    @include('tei.manuscripts.images')
    @if($manuscript->transliteration)
    <text>
        {!! preg_replace(array("/<doc[^>]*>/", "/<\/doc>/"), array("<body>","</body>"), $manuscript->transliteration) !!}
    </text>
    @endif
</TEI>
