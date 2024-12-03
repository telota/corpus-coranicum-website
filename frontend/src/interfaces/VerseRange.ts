import { compare, Verse } from './Verse';

interface VerseRange {
  start: Verse;
  end: Verse;
}

function verseInRange(v: Verse) {
  return (r: VerseRange): boolean => compare(v, r.start) >= 0 && compare(v, r.end) <= 0;
}

function toText(verse: string, verses: string, r: VerseRange): string {
  if (compare(r.start, r.end) === 0) {
    return `Q ${r.start.sura}:${r.start.verse}`;
  }
  return `Q ${r.start.sura}:${r.start.verse} - Q ${r.end.sura}:${r.end.verse}`;
}

function toKey(r: VerseRange): string {
  return `${r.start.sura}:${r.start.verse}-${r.end.sura}:${r.end.verse}`;
}

function displayRange(r: VerseRange, verseSingle: string, versePlural: string):string {
  if (compare(r.start, r.end) === 0) {
    return `${verseSingle} ${r.start.sura}:${r.start.verse}`;
  }
  return `${versePlural} ${r.start.sura}:${r.start.verse}-${r.end.sura}:${r.end.verse}`;
}

export { VerseRange, verseInRange, toText, toKey, displayRange };
