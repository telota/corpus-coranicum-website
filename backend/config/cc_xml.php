<?php
    return [        
        'variants' => [
            'allvariants' => [
                'filename' => 'allvariants',
                'folder' => 'quran_variants/',
                'template' => 'tei.variants.allvariants',
            ],
            'sources' => [
                'filename' => 'sources',
                'folder' => 'quran_variants/',
                'template' => 'tei.variants.allsources',
            ],
            'reader' => [
                'filename' => 'reader',
                'folder' => 'quran_variants/',
                'template' => 'tei.variants.allreader',
            ],
        ],
        'intertexts' => [
            'all' => [
                'filename' => 'intertext-[id]',
                'folder' => 'quran_intertexts/',
                'template' => 'tei.intertexts.all',
            ],
            'categories' => [
                'filename' => 'categories',
                'folder' => 'quran_intertexts/',
                'template' => 'tei.intertexts.categories',
            ],
        ],
        'manuscripts' => [
            'places' => [
                'filename' => 'places',
                'folder' => 'quran_manuscripts/',
                'template' => 'tei.manuscripts.places',
            ],
        ],
        'cairo' => [
            'all' => [
                'filename' => 'cairoquran',
                'folder' => 'cairo_quran/',
                'template' => 'tei.cairo.all',
            ],
        ],
        'concordance' => [
            'sura' => [
                'folder' => 'quran_concordance/',
                'template' => 'tei.concordance.sura',
            ],
        ],
        // 'commentary',
        'cairoquran_languages' => [
            'en',
            'de',
            'fr',
        ],
        # iso latin 639-3 Codes from https://de.wikipedia.org/wiki/%C3%9Cberblicksliste_der_ISO-639-3-Codes
        'languages' => [
            'akk' => 'Akkadisch',
            'gez' => 'Altäthiopisch',
            'gez' => 'Altäthiopisch (Gəʿəz)',
            'chu' => 'Altkirchenslawisch',
            'xna' => 'Altnordarabisch',
            'xna' => 'Altsüdarabisch',
            'ara' => 'Arabisch',
            'arc' => 'Aramäisch',
            'arc' => 'Aramäisch (Hatra)',
            'arc' => 'Aramäisch (Nabatäisch)',
            'arc' => 'Aramäisch (Palmyrenisch)',
            'arc' => 'Aramäisch/Hebräisch',
            'hye' => 'Armenisch',
            'ope' => 'Awestisch',
            'ope' => 'Awestisch/Altpersisch',
            'kat' => 'Georgisch',
            'ell' => 'Griechisch',
            'heb' => 'Hebräisch',
            'cop' => 'Koptisch',
            'lat' => 'Lateinisch',
            'mid' => 'Mandäisch',
            'pal' => 'Mittelpersisch (Pahlavī)',
            'sog' => 'Sogdisch',
            'sux' => 'Sumerisch',
            'syc' => 'Syrisch',
        ]
    ];
