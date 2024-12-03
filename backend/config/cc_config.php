<?php
    return [        
        'languages' => [
            'de',
            'en',
            'fr',
            'ar',
            'fa',
            'ru',
            'tr',
        ],
        'digilib' => [
            'fullscreen' => 'https://corpuscoranicum.de/digitallibrary/servlet/Scaler?fn=/projects/corpus-coranicum/Kairo1924/[bild]&dw=3000&mo=q2',
            'iiif' => 'https://corpuscoranicum.de/digitallibrary/servlet/Scaler/IIIF/projects!corpus-coranicum!',
            'base' => 'https://corpuscoranicum.de/digitallibrary/servlet/Scaler?fn=/projects/corpus-coranicum/',
            'main_folder' => '/projects/corpus-coranicum/',
            'local' => 'https://corpuscoranicum.de/img/[bild]',
            'width_parameter' => '&dw=1000',
            'thumbnail'=>'&dw=800&dh=800&mo=q1,jpg',
        ],
        'zotero' => [
            'link_item' => 'https://www.zotero.org/groups/265673/corpuscoranicum_pub/items/',
        ],
        'fallback_language' => 'en',
        'link_structure'    => [
            'printed_version'   => '/[language]/edition/sura/[sura]/verse/[verse]/print',
            'concordance'       => '/[language]/edition/sura/[sura]/verse/[verse]/concordance/word/[word]',
        ]
    ];
?>
