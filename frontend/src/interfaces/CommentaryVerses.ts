export interface CommentaryVerses {
  content: string;
  verse_start: number;
  verse_end: number;
}

export function commentaryVersesTitle(c: CommentaryVerses): string {
  if (c.verse_start === c.verse_end) {
    return `Vers ${c.verse_start}`;
  }
  return `Verse ${c.verse_start}-${c.verse_end}`;
}

export function commentaryVersesId(sectionId: string, c: CommentaryVerses): string {
  if (c.verse_start === c.verse_end) {
    return `${sectionId}_vers_${c.verse_start}`;
  }
  return `${sectionId}_verse_${c.verse_start}-${c.verse_end}`;
}
