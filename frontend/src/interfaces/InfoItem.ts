import { Link } from './Link';

export interface InfoItem {
  id?: string;
  title: string;
  subtitle?: string;
  image?: string;
  image_caption?: string;
  paragraphs?: string[];
  html?: string;
  bullets?: string[];
  links?: Link[];
  source?: string;
}
