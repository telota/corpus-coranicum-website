export interface TableOfContentsItem {
  text: string;
  link: string;
  children?: TableOfContentsItem[];
}
