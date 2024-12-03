<?xml version="1.0" encoding="UTF-8"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://relaxng.org/ns/structure/1.0"?>
<?xml-model href="../schema/corpus_coranicum.rng" type="application/xml" schematypens="http://purl.oclc.org/dsdl/schematron"?>
<TEI xmlns="http://www.tei-c.org/ns/1.0">
    <teiHeader>
        <fileDesc>
            <titleStmt>
                <title>Printed edition of the Qu'ran, Cairo 1924</title>
            </titleStmt>
            <publicationStmt>
                <publisher>Egyptian Government: Amiri Press: Būlāq (Cairo) and Egyptian Survey (Giza)</publisher>
                <pubPlace>Cairo</pubPlace>
                <date when="1924">1924</date>
            </publicationStmt>
            <sourceDesc>
                <p>The King Fuʾād edition of the Qurʾān was assembled and typeset in the Amīrī Press in Būlāq and printed in the Egyptian Survey in Gizeh in the year 1342 AH (see appendix of the King Fuʾād edition, p. 17: Miṣr ǧumiʿa wa-ruttiba fi l-maṭbaʿati l-ʾamīrīyati bi-Būlāq wa-ṭubiʿa fī maṣlaḥati l-masāḥati bi-l-Ǧīzati sanata 1342 hiǧrī). As a bibliographical record the following is suggested: al-Qurʾān al-karīm, recension of Ḥafṣ (following ʿĀṣim) according to Taisīr and Šāṭibiyya, consonantal text in archaic orthography (rasm ʿuṯmānī), edited by Muḥammad ʿAli al-Ḥusainī al-Ḥaddād et al., Cairo and Gizeh 1342/1924.</p>
                <p>The Egyptian printed Qurʾān of 1924 serves as the reference text for spelling, verse separators and reading (Ḥafṣ ʿan ʿĀṣim) of the digital publications of Corpus Coranicum.</p>
            </sourceDesc>
        </fileDesc>
    </teiHeader>
    <facsimile>
        @forelse ($data['manuscript_images'] as $image)
        <surface n="{{ $image['pageno'] }}, Q {{ $image['first']['sure'] }}:{{ $image['first']['vers'] }}- Q {{ $image['last']['sure'] }}:{{ $image['last']['vers'] }}" xml:id="i{{ $image['pageno'] }}">
            <graphic rend="portrait" url="{{ $image['image'] }}" />
        </surface>
        @empty
        @endforelse
    </facsimile>
    <text>
        <body>
            {{-- Arabic text --}}
            <div type="arabic_text">
                @forelse ($data['arabic'] as $sura)
                <lg n="{{ $sura['sura'] }}" xml:id="sura-{{ str_pad($sura['sura'], 3, 0, STR_PAD_LEFT) }}">
                    @forelse($sura['getSuraQuran'] as $verse)
                    @if(($verse['sura'] == $verse['firstappearance']['first']['sure'])
                    AND ($verse['verse'] == $verse['firstappearance']['first']['vers']))
                    <pb n="{{ $verse['pageno'] }}, Q {{ $verse['firstappearance']['first']['sure'] }}:{{ $verse['firstappearance']['first']['vers'] }}- Q {{ $verse['firstappearance']['last']['sure'] }}:{{ $verse['firstappearance']['last']['vers'] }}" facs="#i{{ $verse['pageno'] }}" />
                    @endif
                    <lg n="{{ $verse['verse'] }}" xml:id="verse-{{ str_pad($verse['sura'], 3, 0, STR_PAD_LEFT) }}-{{ str_pad($verse['verse'], 3, 0, STR_PAD_LEFT) }}">
                        <l n="+++1">
                            @forelse ($verse['getSuraVerseQuran'] as $word)
                            <w xml:id="w-{{ str_pad($word['sure'], 3, 0, STR_PAD_LEFT) }}-{{ str_pad($word['vers'], 3, 0, STR_PAD_LEFT) }}-{{ str_pad($word['wort'], 3, 0, STR_PAD_LEFT) }}">{{ trim($word['arab']) }}</w>
                            @empty
                            @endforelse
                        </l>
                    </lg>
                    @empty
                    @endforelse
                </lg>
                @empty
                @endforelse
            </div>
            {{-- Transcriptions --}}
            <div type="transcription">
                @forelse ($data['arabic'] as $sura)
                <lg n="{{ $sura['sura'] }}" xml:id="transcribed-sura-{{ str_pad($sura['sura'], 3, 0, STR_PAD_LEFT) }}">
                    @forelse($sura['getSuraQuran'] as $verse)
                    <lg n="{{ $verse['verse'] }}" xml:id="transcribed-verse-{{ str_pad($verse['sura'], 3, 0, STR_PAD_LEFT) }}-{{ str_pad($verse['verse'], 3, 0, STR_PAD_LEFT) }}">
                        <l n="1">
                            @forelse ($verse['getSuraVerseQuran'] as $word)
                            <w xml:id="transcribed-w-{{ str_pad($word['sure'], 3, 0, STR_PAD_LEFT) }}-{{ str_pad($word['vers'], 3, 0, STR_PAD_LEFT) }}-{{ str_pad($word['wort'], 3, 0, STR_PAD_LEFT) }}" type="word_cc" >{{ trim($word['transkription']) }}</w>
                            @empty
                            @endforelse
                        </l>
                    </lg>
                    @empty
                    @endforelse
                </lg>
                @empty
                @endforelse
            </div>
            {{-- Translation --}}
            @forelse($data['languages'] as $language)
            <div type="translation" xml:lang="{{ $language }}">
                @forelse ($data[$language] as $sura)
                <lg n="NAME" xml:id="translated-{{$language}}-sura-{{ str_pad($sura['sura'], 3, 0, STR_PAD_LEFT) }}-{{ $language }}" >
                    @forelse($sura['translations'] as $verse)
                    <lg n="{{ str_pad($verse['verse'], 3, 0, STR_PAD_LEFT) }}" xml:id="translated-{{ $language }}-verse-{{ str_pad($sura['sura'], 3, 0, STR_PAD_LEFT) }}-{{ str_pad($verse['verse'], 3, 0, STR_PAD_LEFT) }}">
                        <l n="1">{{ $verse['text'] }}</l>
                    </lg>
                    @empty
                    @endforelse
                </lg>
                @empty
                @endforelse
            </div>
            @empty
            @endforelse
        </body>
    </text>
</TEI>
