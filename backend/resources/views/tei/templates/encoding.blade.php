<encodingDesc>
    <projectDesc>
        <p>Created as part of
            <name type="project">Corpus Coranicum Project</name>
        </p>
    </projectDesc>
    <classDecl>
        <taxonomy xml:id="variantsreader">
            <bibl>Variants Readers</bibl>
        </taxonomy>
        <taxonomy xml:id="variantssource">
            <bibl>Variants Sources</bibl>
        </taxonomy>
        <taxonomy xml:id="tuk.cat">
            <bibl>TUK Categories</bibl>
        </taxonomy>
        <taxonomy xml:id="geoname">
            <bibl>
                <ref target="https://www.geonames.org/">Geonames</ref>
            </bibl>
        </taxonomy>
        <taxonomy xml:id="local">
            <bibl>'Sigle' is a unique id assigned by Michael Marx to a specific reader in the reading
                variants.
            </bibl>
        </taxonomy>
        {{--
          these are examples of how to use the classDecl element:
              <taxonomy xml:id="GEONAMES">
            <bibl>
                <ref target="https://www.geonames.org/">Geonames</ref>
            </bibl>
        </taxonomy>
        <taxonomy xml:id="LCSH">
            <bibl>
                <ref target="http://id.loc.gov/authorities/about.html#lcsh">Library of Congress
                    Subject Headings</ref>
            </bibl>
        </taxonomy>
        <taxonomy xml:id="VIAF">
            <bibl>
                <ref target="https://viaf.org/">Virtual International Authority File</ref>
            </bibl>encodingDesc
            <bibl>
                <ref target="http://www.getty.edu/research/tools/vocabularies/tgn/">Getty
                    Thesaurus of Geographical Names</ref>
            </bibl>
        </taxonomy>
        <taxonomy xml:id="LANG">
            <bibl>
                <ref target="https://www.loc.gov/standards/iso639-2/php/code_list.php">ISO
                    Language Codes</ref>
            </bibl>
        </taxonomy>
        <taxonomy xml:id="MARC">
            <bibl>
                <ref target="https://www.loc.gov/marc/relators/relaterm.html">MARC Relator
                    Terms</ref>
            </bibl>
        </taxonomy>
        <taxonomy xml:id="ZOTERO">
            <bibl>
                <ref target="https://www.zotero.org/">Zotero</ref>
            </bibl>
        </taxonomy>
        <taxonomy xml:id="TS">
            <bibl>TextStellen</bibl>
        </taxonomy>
        <taxonomy xml:id="TSK">
            <bibl>TextStelleKoran</bibl>
        </taxonomy>--}}
    </classDecl>
</encodingDesc>
<revisionDesc>
    <change type="TEI_record_creater">
        <persName role="dtc">Yasmin Faghihi</persName>
    </change>
    @if(isset($type) && $type =='intertext')
        @forelse ($data['editors'] as $editor)
            <change type="transliteration">
                <persName key="" role="trc" {{-- VIAF --}}>{{$editor->bearbeiter}}</persName>
            </change>
        @empty
        @endforelse
    @endif
</revisionDesc>
