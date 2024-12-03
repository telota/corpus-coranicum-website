import { ConcordanceAnalyis } from './ConcordanceAnalysis';

export interface ConcordanceData{
  analyses: ConcordanceAnalyis[];
  arabic_text: string[];
  transcription_text: string[];
}
