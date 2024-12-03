import { TextNode } from './TextNode';

export interface Lang {
  name: 'lang';
  children: TextNode[];
}
