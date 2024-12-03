/* eslint-disable no-restricted-syntax */
/* eslint-disable @typescript-eslint/no-var-requires */
// For generating a batch sql script to put word translations into the database
// This script is ugly, and just for getting things done quick and dirty.
const { assert } = require('console');
const fs = require('fs');

fs.readFile('./frontend/de.json', 'utf8', (err, de) => {
  if (err) {
    console.error(err);
    return;
  }

  fs.readFile('./frontend/en.json', 'utf8', (err, en) => {
    if (err) {
      console.error(err);
      return;
    }

    const de_keys = JSON.parse(de);
    const en_keys = JSON.parse(en);

    let sqlString = 'INSERT INTO translations (`key`, de, en, fr, ar, fa, ru, tr, user_id, created_at) VALUES';

    // eslint-disable-next-line no-restricted-syntax
    for (const [category, keys] of Object.entries(de_keys)) {
      for (const [key, field] of Object.entries(keys)) {
        const wort_key = `${category}_${key}`;
        console.log(`'${key}' => '${wort_key}',`);
        // console.log(wort_key);
        const deutsch = de_keys[category][key];
        const english = en_keys[category][key];
        sqlString += ` ('${wort_key}','${deutsch}','${english}',' ','','','','',70, values(curdate())), `;
      }
    }
    console.log(sqlString);
  });
});
