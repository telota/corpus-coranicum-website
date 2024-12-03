import { toPaddedText, Word } from './Word';

interface ManuscriptPassage {
  start: Word;
  end: Word;
}

function toText(p: ManuscriptPassage): string {
  return `${toPaddedText(p.start)}-${toPaddedText(p.end)}`;
}

export { ManuscriptPassage, toText };
