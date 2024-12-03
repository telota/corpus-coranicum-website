import { VariantsContribution } from './VariantsContribution';
import { VariantsReading } from './VariantsReading';
import { VariantsReferenceVerse } from './VariantsReferenceVerse';

export interface VariantsVerse {
  variant_readings: VariantsReading[];
  reference: VariantsReferenceVerse;
  commentary: string;
  citations: VariantsContribution[];
}
