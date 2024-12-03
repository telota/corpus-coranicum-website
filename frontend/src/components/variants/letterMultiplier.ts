const replacements = [
  {
    input: 'a',
    replace: 'aāä',
  },
  {
    input: 'd',
    replace: 'dḍḏ',
  },
  {
    input: 'g',
    replace: 'gǧġ',
  },
  {
    input: 'h',
    replace: 'hḥḫ',
  },
  {
    input: 'i',
    replace: 'iī',
  },
  {
    input: 'o',
    replace: 'oö',
  },
  {
    input: 's',
    replace: 'sš',
  },
  {
    input: 't',
    replace: 'tṯṭ',
  },
  {
    input: 'u',
    replace: 'uūü',
  },
  {
    input: "'",
    replace: "'ʿʾ",
  },
];

function makeSearchTerm(word: string): string {
  let editedWord: string = word;
  replacements.forEach((r) => {
    editedWord = editedWord.replace(new RegExp(r.input, 'gi'), `[${r.replace}]`);
  });

  return editedWord;
}

// eslint-disable-next-line import/prefer-default-export
export { makeSearchTerm };
