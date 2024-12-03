import { VerseRange } from './VerseRange';

interface IntertextSummary {
  id: number;
  title: string;
  entry_author: string;
  language: string;
  location: string;
  dated: string;
  source: string;
  intertext_author: string,
  category: string;
  supercategory: string;
  range: VerseRange;
}

function compareByTitle(a: IntertextSummary, b: IntertextSummary): number {
  return a.title.localeCompare(b.title, 'de');
}
export {
  IntertextSummary,
  compareByTitle,
};
