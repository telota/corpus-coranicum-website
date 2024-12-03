#!/bin/bash

set -e
set -u

declare -a languages=("de" "en" "fr")

function get_translations () {
  curl "https://api.corpuscoranicum.de/api/language/$1/translations" | json_pp  | jq .data > ./database/$1.json
}



for i in "${languages[@]}"
do
  get_translations $i
done
