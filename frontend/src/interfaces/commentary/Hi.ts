import { Lang } from './Lang';
import { Q } from './Q';
import { TextNode } from './TextNode';

export interface Hi {
  name: 'hi';
  attributes: {
    rend: 'superscript' | 'bold' | 'italic';
  };
  children: (Lang | TextNode | Q)[];
}
