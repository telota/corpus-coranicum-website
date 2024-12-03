# Export XML/TEI files

call following commands to create xml files in storage/tei-export

+ php artisan tei:all
+ php artisan tei:meta-texts
+ php artisan tei:cairo
+ php artisan tei:intertexts
+ php artisan tei:variants
+ php artisan tei:manuscripts
+ php artisan tei:manuscript-places
+ php artisan tei:commentary

One can validate the TEI export with something like this: `find . -name '*.xml' -print | parallel --tag jing ./corpus_coranicum.rng > validation.txt`