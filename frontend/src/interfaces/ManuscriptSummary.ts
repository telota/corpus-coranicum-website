import { ArchiveSummary } from './ArchiveSummary';
import { ManuscriptPageResult } from './ManuscriptPageResult';

export interface ManuscriptSummary {
  manuscript_id: number;
  title: string;
  archive: ArchiveSummary;
  pages: ManuscriptPageResult[];
}
