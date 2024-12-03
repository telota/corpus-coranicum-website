interface Verse {
  sura: number;
  verse: number;
}

function compare(v1: Verse, v2: Verse): number {
  if (v1.sura < v2.sura) {
    return -1;
  }

  if (v1.sura === v2.sura && v1.verse < v2.verse) {
    return -1;
  }

  if (v1.sura === v2.sura && v1.verse === v2.verse) {
    return 0;
  }

  return 1;
}

function padNumber(n: number): string {
  const str = n.toString();
  return str.padStart(3, '0');
}

function toPaddedText(v: Verse): string {
  return `${padNumber(v.sura)}:${padNumber(v.verse)}`;
}

export { Verse, compare, toPaddedText };
