import { Locale } from 'vue-i18n';
import { Verse } from './Verse';

export type VerseKey = string;

export function toVerseKey(verse: Verse, lang?: Locale): VerseKey {
  if (lang) {
    return `${verse.sura}:${verse.verse}-${lang}`;
  }
  return `${verse.sura}:${verse.verse}`;
}
