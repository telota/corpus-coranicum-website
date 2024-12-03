import { CommentaryIntroductionSection } from './CommentaryIntroductionSection';
import { TableOfContentsItem } from './TableOfContentsItem';

export interface CommentaryIntroduction {
  title: string;
  author: string;
  subauthor: string;
  table_of_contents: TableOfContentsItem[];
  sections: CommentaryIntroductionSection[];
  how_to_cite: string;
}
