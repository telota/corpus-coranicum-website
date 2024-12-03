import { CommentarySection } from './CommentarySection';

export interface CommentarySectionGroup {
  id: string;
  heading: string;
  sections: CommentarySection[];
}

export function isSectionGroup(
  s: CommentarySection | CommentarySectionGroup,
): s is CommentarySectionGroup {
  return (s as CommentarySectionGroup).heading !== undefined;
}
