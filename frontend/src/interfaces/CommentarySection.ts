import { CommentaryVerses } from './CommentaryVerses';

export interface CommentarySection {
  id: string;
  general_title: string;
  specific_title: string;
  comment_title: string;
  content?: string;
  verse_content?: CommentaryVerses[];
  works_cited: string | null;
}

export function sectionTitle(s: CommentarySection): string {
  if (s.specific_title) {
    return `${s.general_title}: ${s.specific_title}`;
  }

  return s.general_title;
}
