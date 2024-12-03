import { XmlNode } from './XmlNode';

export interface XmlTable {
  name: 'table';
  tableContent: XmlNode[][];
}
