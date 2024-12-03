export interface Word {
  sura: number;
  verse: number;
  word: number | null;
}

function padNumber(n: number): string {
  const str = n.toString();
  return str.padStart(3, '0');
}

export function toPaddedText(w: Word): string {
  const verse = `${padNumber(w.sura)}:${padNumber(w.verse)}`;
  if (w.word !== null) {
    return `${verse}:${padNumber(w.word)}`;
  }
  return verse;
}
