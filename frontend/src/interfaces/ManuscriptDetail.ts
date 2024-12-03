import { html } from '@/interfaces/Html';
import { ArchiveSummary } from './ArchiveSummary';
import { ManuscriptPageSummary } from './ManuscriptPageSummary';
import { ManuscriptPassage } from './ManuscriptPassage';

interface BibliographyEntry {
  citation: string;
  zotero_key: string;
}
export interface ManuscriptDetail {
  id: number;
  title?: string;

  call_number: string;
  format?: string;
  dimensions?: string;
  format_text_field?: string;
  date: string;
  extent?: string;
  number_of_folios?: number;
  line_count?: string,
  line_min?: number;
  line_max?: number;
  carbon_dating?: string;
  archive: ArchiveSummary;
  found?: string;
  provenance?: string;
  provenances?: string[];
  material_condition?: string;
  material_kind?: string;
  writing_surface?: string;
  codicology: html | null;
  writing_style?: string | null;
  script_styles?: string[];
  paleography: html | null;
  literature?: string | null;
  editors?: string;
  citation?: string;
  commentary?: string | null;
  catalogue_entry?: string | null;
  pages: ManuscriptPageSummary[];
  passages: ManuscriptPassage[];
  bibliography?: BibliographyEntry[];
}

export function manuscriptTitle(m: ManuscriptDetail): string {
  if (m.title) {
    return m.title;
  }
  return `${m.archive.name}: ${m.call_number}`;
}
