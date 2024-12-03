import { CommentaryLine } from './CommentaryLine';
import { CommentarySection, sectionTitle } from './CommentarySection';
import { CommentarySectionGroup, isSectionGroup } from './CommentarySectionGroup';
import { commentaryVersesId, commentaryVersesTitle } from './CommentaryVerses';
import { TableOfContentsItem } from './TableOfContentsItem';

export interface Commentary {
  sura: number;
  title: string;
  author: string;
  text_structure: CommentaryLine[];
  sections: (CommentarySectionGroup | CommentarySection)[];
  how_to_cite: string;
}

function sectionToItem(s: CommentarySection): TableOfContentsItem {
  const entry: TableOfContentsItem = {
    text: sectionTitle(s),
    link: s.id,
  };

  if (s.verse_content) {
    entry.children = s.verse_content.map((vc) => ({
      text: commentaryVersesTitle(vc),
      link: commentaryVersesId(s.id, vc),
    }));
  }
  return entry;
}

export function toTableOfContents(c: Commentary): TableOfContentsItem[] {
  const tableOfContents: TableOfContentsItem[] = [];

  tableOfContents.push({
    text: 'Text',
    link: 'text',
  });

  tableOfContents.push(
    ...c.sections.map((s) => {
      if (isSectionGroup(s)) {
        return {
          text: s.heading,
          link: s.id,
          children: s.sections.map((subS) => sectionToItem(subS)),
        };
      }
      return sectionToItem(s);
    }),
  );

  return tableOfContents;
}
