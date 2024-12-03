import { error } from './Error';
import { MaybeImages } from './ImageNotAllowed';
import { ManuscriptPassage } from './ManuscriptPassage';
import { VerseTranslation } from './VerseTranslaton';

export interface ManuscriptPageDetail {
  manuscript_id: number;
  page_id: number;
  folio: number;
  side: string;
  editors: string;
  passages: ManuscriptPassage[];
  images: MaybeImages;
  transliteration: string | null;
  verses: VerseTranslation[] | error;
}
