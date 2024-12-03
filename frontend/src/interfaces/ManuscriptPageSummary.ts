import { ManuscriptPassage } from './ManuscriptPassage';

export interface ManuscriptPageSummary {
  page_id: number;
  folio: string;
  side: string | null;
  passages: ManuscriptPassage[];
}
