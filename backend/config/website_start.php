<?php

/* At the moment we are only using the 'image', 'title' and 'subtitle' fields in this file.
 The remaining fields are there becuase they were present on the old site.
*/
return
	[
		[
			"image" => "about-image.jpg",
			"title" => ["translate" => "about_heading"],
			"subtitle" => ["translate" => "about_description_short"],
			"paragraphs" => [
				["translate" => "about_description"],
			],
			"links" => [
				[
					"url" => "about",
					"add_language" => true,
					"text" => ["translate" => "about_heading"],
				],
				[
					"url" => "about/research",
					"add_language" => true,
					"text" => ["translate" => "forschung_heading"],
				],
				[
					"url" => "about/tools",
					"add_language" => true,
					"text" => ["translate" => "tools_heading"],
				],
				[
					"url" => "about/sources",
					"add_language" => true,
					"text" => ["translate" => "materialien_heading"],
				],
				[
					"url" => "about/team",
					"add_language" => true,
					"text" => ["translate" => "projektdarstellung_mitarbeiter_heading"],
				],
			],
		],
		[
			"image" => "druckausgabe-image.jpg",
			"title" => ["translate" => "menu_kairo"],
			"subtitle" => ["translate" => "druckausgabe_beschreibung"],
			"paragraphs" => [
				["translate" => "einleitung_index"],
			],
			"bullets" => [
				["translate" => "bullets_druckausgabe_1"],
				["translate" => "bullets_druckausgabe_2"],
				["translate" => "bullets_druckausgabe_3"],
			],
			"links" => [
				[
					"url" => "print",
					"add_language" => true,
					"text" => ["translate" => "uebersicht_heading"],
				],
				[
					"url" => "verse-navigator/sura/1/verse/1/print",
					"add_language" => true,
					"text" => ["translate" => "homepage_print_edition_by_verse"],
				],
			]
		],
		[
			"image" => "handschriften-image.jpg",
			"title" => ["translate" => "menu_handschriften_title"],
			"subtitle" => ["translate" => "handschriften_beschreibung"],
			"paragraphs" => [
				["translate" => "einleitung_handschriften"],
			],
			"bullets" => [
				["translate" => "bullets_handschriften_1"],
				["translate" => "bullets_handschriften_2"],
				["translate" => "bullets_handschriften_3"],
				["translate" => "bullets_handschriften_4"],
				["translate" => "bullets_handschriften_5"],
			],
			"links" => [
				[
					"url" => "manuscripts",
					"add_language" => true,
					"text" => ["translate" => "uebersicht_heading"],
				],
				[
					"url" => "verse-navigator/sura/20/verse/1/manuscripts",
					"add_language" => true,
					"text" => ["translate" => "homepage_manuscripts_by_verse"],
				],
			],
		],
		[
			"image" => "lesarten-image.jpg",
			"title" => ["translate" => "menu_lesarten_title"],
			"subtitle" => ["translate" => "lesarten_beschreibung"],
			"paragraphs" => [
				["translate" => "einleitung_lesarten"],
			],
			"bullets" => [
				["translate" => "bullets_lesarten_1"],
				["translate" => "bullets_lesarten_2"],
				["translate" => "bullets_lesarten_3"],
			],
			"links" => [
				[
					"url" => "variants",
					"add_language" => true,
					"text" => ["translate" => "uebersicht_heading"],
				],
				[
					"url" => "verse-navigator/sura/1/verse/1/variants",
					"add_language" => true,
					"text" => ["translate" => "homepage_variants_by_verse"],
				],
			]
		],
		[
			"image" => "kontexte-image.jpg",
			"title" => ["translate" => "menu_intertexte"],
			"subtitle" => ["translate" => "kontexte_beschreibung"],
			"paragraphs" => [
				["translate" => "einleitung_kontexte"],
			],
			"bullets" => [
				["translate" => "bullets_kontexte_1"],
				["translate" => "bullets_kontexte_2"],
				["translate" => "bullets_kontexte_3"],
			],
			"links" => [
				[
					"url" => "intertexts",
					"add_language" => true,
					"text" => ["translate" => "uebersicht_heading"],
				],
				[
					"url" => "verse-navigator/sura/32/verse/10/intertexts",
					"add_language" => true,
					"text" => ["translate" => "homepage_intertexts_by_verse"],
				],
			]
		],
		[
			"image" => "kommentar-image.jpg",
			"title" => ["translate" => "menu_kommentar"],
			"subtitle" => ["translate" => "kommentar_beschreibung"],
			"paragraphs" => [
				["translate" => "einleitung_kommentar"],
			],
			"bullets" => [
				["translate" => "bullets_kommentar_1"],
				["translate" => "bullets_kommentar_2"],
				["translate" => "bullets_kommentar_3"],
				["translate" => "bullets_kommentar_4"],
			],
			"links" => [
				[
					"url" => "commentary",
					"add_language" => true,
					"text" => ["translate" => "uebersicht_heading"],
				],
				[
					"url" => "verse-navigator/sura/1/verse/1/commentary",
					"add_language" => true,
					"text" => ["translate" => "homepage_commentary_by_sura"],
				],
				[
					"url" => "commentary/introduction/early-mecca",
					"add_language" => true,
					"text" => ["translate" => "ueberschrift_einleitung_mekka1"],
				],
				[
					"url" => "commentary/introduction/middle-mecca",
					"add_language" => true,
					"text" => ["translate" => "ueberschrift_einleitung_mekka2"],
				],
				[
					"url" => "commentary/introduction/late-middle-mecca",
					"add_language" => true,
					"text" => ["translate" => "kommentar_spaetmekkanisch_einleitung"],
				],
			],
		],
		[
			"image" => "CC-Background-Cropped.jpg",
			"title" => ["translate" => "header_concordance"],
			"subtitle" => ["translate" => "concordance_header_rafi_talmon"],
			"links" => [
				[
					"url" => "concordance",
					"add_language" => true,
					"text" => ["translate" => "uebersicht_heading"],
				],
				[
					"url" => "verse-navigator/sura/1/verse/1/concordance/word/1",
					"add_language" => true,
					"text" => ["translate" => "homepage_concordance_by_word"],
				],
			]
		]
	];
