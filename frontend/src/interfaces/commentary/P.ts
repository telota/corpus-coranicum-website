import { Lang } from './Lang';
import { TextNode } from './TextNode';
import { XmlNode } from './XmlNode';
import { XmlTable } from './XmlTable';

export interface P {
  name: 'p';
  children: (XmlTable | XmlNode)[];
}
