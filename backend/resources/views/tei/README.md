# Corpus Coranicum - TEI DATA

TEI Data for the Digital Project "Corpus Coranicum" (https://corpuscoranicum.de)

This is a TEI ([Text Encoding Initiative](https://tei-c.org/)) Export of the Corpus Coranicum project, which ran from 2007 to 2024 at the [Berlin Brandenburg Academy of Sciences and Humanities (BBAW)](https://www.bbaw.de/forschung/corpus-coranicum).
* The dataset that forms the basis of this export comes from other XML project files and from the project's MySQL database.
* A full list of contributors to the Corpus Coranicum Project can be seen here:  https://corpuscoranicum.de/en/about/team.
* The TEI schema for this TEI dataset was developed by Yasmin Faghihi (Cambridge) and Huw Jones (Cambridge).
* Claus Franke (BBAW - TELOTA) and Marcus Lampert (BBAW - TELOTA) did the technical implementation of feeding the project data into the TEI schema.

## Technical Information

* As indicated in beginning of each Xml document, the TEI validates against a united `corpus_coranicum.rng` schema. However, there are parts of files that give validation errors.

## Contents

* `cairo_quran`: The 1924 Cairo edition of the Quran, including English, German, and French translations.
* `quran_commentary`: Chronological, literary-critical commentary on the Quran, organized by Sura and time period in which the Suras where likely written.
* `quran_concordance`: A full grammatical parse of every word in the Quran, based on the concordance of Rafael Talmon (1948-2004).
* `quran_intertexts`: A database of intertextual connections between the Quran and various texts from late antiquity and earlier.
* `quran_manuscripts`: Information on over Quran 2500 manuscripts dating from around 650 to the present.
* `quran_variants`: Variant readings of the Quran included in early sources of Muslim scholarly tradition.

## Citation
Corpus Coranicum Project, ed. Michael Marx. TEI Data. Berlin-Brandenburg Academy of Sciences and Humanities. https://github.com/telota/corpus-coranicum-tei.

## Licence

CC-BY-SA 4.0

## Contact

* Michael Marx (marx@bbaw.de), Berlin-Brandenburgische Akademie der Wissenschaften
* TELOTA (telota@bbaw.de), Berlin-Brandenburgische Akademie der Wissenschaften
