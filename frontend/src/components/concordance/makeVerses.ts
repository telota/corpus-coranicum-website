import { DeepReadonly } from 'vue';
import { ConcordanceVerse } from '@/interfaces/ConcordanceVerse';

function displayText(word: number, text: Readonly<string[]>): string {
  const withBold = text.slice();
  withBold[word - 1] = `<b>${withBold[word - 1]}</b>`;
  return withBold.join(' ');
}

function displayReference(
  suraText: string,
  verseText: string,
  verse: DeepReadonly<ConcordanceVerse>,
): string {
  return ''.concat(
    suraText,
    ' ',
    String(verse.sura),
    ', ',
    verseText,
    ' ',
    String(verse.verse),
    ': ',
    displayText(verse.word, verse.transcription_text),
  );
}

function mapToReferences(
  suraText: string,
  verseText: string,
  verses: DeepReadonly<ConcordanceVerse[]>,
): ConcordanceVerse[] {
  return verses.map((v) => ({
    ...v,
    transcription_text: [displayReference(suraText, verseText, v)],
  }));
}

export default mapToReferences;
