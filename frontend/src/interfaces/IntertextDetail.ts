import { html } from './Html';
import { IntertextImage } from './IntertextImage';
import { IntertextSummary } from './IntertextSummary';
import { Translations } from './Translations';
import { VerseRange } from './VerseRange';

export interface IntertextDetail {
  id: number;
  title: string;
  author?: string;
  entry_author: string;
  language: string;
  location: string;
  dated: string;
  source: html;
  intertext_author: string;
  translation_source: string;
  identified_by: html;
  notes: string;
  content: string;
  content_direction: string;
  transcription: string;
  translation: Translations;
  literature: string;
  images: IntertextImage[];
  first_published: string;
  updated_at: string;
  category: string;
  supercategory: string;
  passages: VerseRange[];
  sura_commentaries: number[];
}

export function makeCategory(i: IntertextDetail | IntertextSummary): string {
  if (i.supercategory) {
    return `${i.supercategory} ➞ ${i.category}`;
  }
  return i.category;
}
