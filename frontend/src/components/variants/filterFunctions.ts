import { VariantsReading } from '@/interfaces/VariantsReading';

function indexRows(table: VariantsReading[]): Map<number, string> {
  const readings = new Map<number, string>();

  table.forEach((reading) => {
    readings.set(
      reading.reading_id,
      reading.work.display_name.concat(
        ...reading.readers.map((r) => r.display_name),
        ...Object.values(reading.variants),
      ),
    );
  });

  return readings;
}

// eslint-disable-next-line import/prefer-default-export
export { indexRows };
