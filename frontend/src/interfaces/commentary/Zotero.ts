import { Hi } from './Hi';
import { TextNode } from './TextNode';

export interface Zotero {
  name: 'bibl';
  attributes: {
    Zotero_Id_1: string;
  };
  children: (TextNode | Hi)[];
}
