<?php
return
	[
		[
			"image" => "Bergstraesser.jpg",
			"image_caption" => ["translate" => "bergstraesser_image_description"],
			"title" => ["translate" => "bergstraesser_title"],
			"paragraphs" => [
				["translate" => "bergstraesser_description"],
			],
		],
		[
			"id"	=> "zotero",
			"image" => "cc-bibliothek.jpg",
			"image_caption" => ["translate" => "opac_image_description"],
			"title" => ["translate" => "opac_title"],
			"paragraphs" => [
				["translate" => "opac_description"],
				["translate" => "opac_description_2"]
			],
			"links" => [
				[
					"url" =>	"https://vzopc4.gbv.de/DB=38/CMD?ACT=SRCHA&IKT=1016&SRT=YOP&TRM=SSt+B4+CoCo",
					"text" => ["translate" => "opac_link"],
				],
				[
					"url" => "https://www.zotero.org/groups/corpuscoranicum_pub/",
					"text"	=> ["translate" => "zotero_link"],
				]
			],

		],
	];
