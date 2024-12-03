<?xml version="1.0" encoding="UTF-8"?>
<?xml-model href="http://www.tei-c.org/release/xml/tei/custom/schema/relaxng/tei_all.rng" type="application/xml"
	schematypens="http://purl.oclc.org/dsdl/schematron"?>
<TEI xmlns="http://www.tei-c.org/ns/1.0">
    <teiHeader>
        <fileDesc>
            <titleStmt>
                <title>Concordance - Sura {{$data['sura']}}</title>
                @include('tei.templates.respStmt')
            </titleStmt>
            @include('tei.templates.publisher')
            <sourceDesc>
                <p>The Concordance of Rafi Talmon edited by the Corpus Coranicum</p>
            </sourceDesc>
        </fileDesc>
        @include('tei.templates.encoding')
    </teiHeader>
    <text>
        <body>
            <div>
                <ab>
                    @forelse ($data['words'] as $word)
                    <w>
                        <seg type="sura">{{ $word ['sura'] }}</seg>
                        <seg type="verse">{{ $word ['verse'] }}</seg>
                        <seg type="word_number">{{ $word ['word_no'] }}</seg>
                        <seg type="word_rafi_talmon">{{ $word ['word_rt'] }}</seg>
                        <seg type="word_corpus_coranicum">{{ $word ['word_cc'] }}</seg>
                        <seg type="analysis_number">{{ $word ['analysis_no'] }}</seg>
                        <seg type="base_rafi_talmon">{{ $word ['base_rt'] }}</seg>
                        <seg type="base_corpus_coranicum">{{ $word ['base_cc'] }}</seg>
                        <seg type="root_rafi_talmon">{{ $word ['root_rt'] }}</seg>
                        <seg type="root_corpus_coranicum">{{ $word ['root_cc'] }}</seg>
                        <seg type="analyse_prefix1">{{ $word ['analyse_prefix1'] }}</seg>
                        <seg type="analyse_prefix1_part_of_speech">{{ $word ['analyse_prefix1_part_of_speech'] }}</seg>
                        <seg type="analyse_prefix1_semantic">{{ $word ['analyse_prefix1_semantic'] }}</seg>
                        <seg type="analyse_prefix2">{{ $word ['analyse_prefix2'] }}</seg>
                        <seg type="analyse_prefix2_part_of_speech">{{ $word ['analyse_prefix2_part_of_speech'] }}</seg>
                        <seg type="analyse_prefix2_semantic">{{ $word ['analyse_prefix2_semantic'] }}</seg>
                        <seg type="analyse_prefix3">{{ $word ['analyse_prefix3'] }}</seg>
                        <seg type="analyse_prefix3_part_of_speech">{{ $word ['analyse_prefix3_part_of_speech'] }}</seg>
                        <seg type="analyse_prefix3_semantic">{{ $word ['analyse_prefix3_semantic'] }}</seg>
                        <seg type="analyse_part_of_speech">{{ $word ['analyse_part_of_speech'] }}</seg>
                        <seg type="analyse_subcategory">{{ $word ['analyse_subcategory'] }}</seg>
                        <seg type="analyse_semantic">{{ $word ['analyse_semantic'] }}</seg>
                        <seg type="analyse_semantic2">{{ $word ['analyse_semantic2'] }}</seg>
                        <seg type="analyse_pattern">{{ $word ['analyse_pattern'] }}</seg>
                        <seg type="analyse_aspect">{{ $word ['analyse_aspect'] }}</seg>
                        <seg type="analyse_actpass">{{ $word ['analyse_actpass'] }}</seg>
                        <seg type="analyse_mortality">{{ $word ['analyse_mortality'] }}</seg>
                        <seg type="analyse_mood">{{ $word ['analyse_mood'] }}</seg>
                        <seg type="analyse_prefix">{{ $word ['analyse_prefix'] }}</seg>
                        <seg type="analyse_gender">{{ $word ['analyse_gender'] }}</seg>
                        <seg type="analyse_number">{{ $word ['analyse_number'] }}</seg>
                        <seg type="analyse_casefld">{{ $word ['analyse_casefld'] }}</seg>
                        <seg type="analyse_person">{{ $word ['analyse_person'] }}</seg>
                        <seg type="analyse_dependent_pron">{{ $word ['analyse_dependent_pron'] }}</seg>
                        <seg type="analyse_dependent_person">{{ $word ['analyse_dependent_person'] }}</seg>
                        <seg type="analyse_dependent_number">{{ $word ['analyse_dependent_number'] }}</seg>
                        <seg type="analyse_dependent_gender">{{ $word ['analyse_dependent_gender'] }}</seg>
                        <seg type="analyse_definite">{{ $word ['analyse_definite'] }}</seg>
                        <seg type="analyse_diptotic">{{ $word ['analyse_diptotic'] }}</seg>
                        <seg type="analyse_full_analyse">{{ $word ['analyse_full_analyse'] }}</seg>
                        <seg type="created_at">{{ $word ['created_at'] }}</seg>
                        <seg type="updated_at">{{ $word ['updated_at'] }}</seg>
                    </w>
                    @empty
                    @endforelse
                </ab>
            </div>
        </body>
    </text>
</TEI>
