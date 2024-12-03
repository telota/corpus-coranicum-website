import { TextNode } from './TextNode';

export interface Q {
  name: 'q';
  attributes: {
    type: 'koran';
    versstart: string;
    versend: string;
  };
  children: TextNode[];
}
