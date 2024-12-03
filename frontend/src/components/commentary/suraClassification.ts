const earlyMecca: number[] = [
  93, 94, 95, 97, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 111, 81, 82, 84, 85, 86, 87, 88,
  89, 90, 91, 92, 96, 53, 74, 75, 77, 78, 79, 80, 51, 52, 55, 56, 68, 69, 70, 73, 83,
];

const middleMecca: number[] = [
  1, 54, 37, 15, 50, 20, 26, 71, 44, 76, 38, 19, 17, 43, 36, 25, 23, 114, 27, 72, 67, 21, 18,
];

const spatMecca: number[] = [
  32, 41, 45, 16, 30, 11, 14, 12, 40, 28, 39, 29, 31, 42, 10, 34, 35, 7, 46, 6, 13, 112, 113,
];

const medina: number[] = [
  2, 98, 64, 62, 8, 47, 3, 61, 57, 4, 65, 59, 33, 63, 24, 58, 22, 48, 66, 60, 110, 49, 9, 5,
];

// eslint-disable-next-line import/prefer-default-export
export function commentaryEra(sura: number): null | string {
  if (earlyMecca.includes(sura)) {
    return 'early-mecca';
  }
  if (middleMecca.includes(sura)) {
    return 'middle-mecca';
  }
  return null;
}
