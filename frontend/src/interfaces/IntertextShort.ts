interface IntertextShort {
  id: number;
  title: string;
  language: string;
  category: string;
  supercategory: string;
  sura: number;
  verse: number;
}

function groupBy(
  list: IntertextShort[],
  keyGetter: (i: IntertextShort) => string,
): Map<string, IntertextShort[]> {
  const map = new Map<string, IntertextShort[]>();
  list.forEach((item) => {
    const key = keyGetter(item);
    const collection = map.get(key);
    if (!collection) {
      map.set(key, [item]);
    } else {
      collection.push(item);
    }
  });
  const sorted = new Map([...map.entries()].sort());

  map.forEach((value: IntertextShort[]) => {
    value.sort((a, b) => {
      if (a.title < b.title) {
        return -1;
      }
      if (a.title > b.title) {
        return 1;
      }
      return 0;
    });
  });

  return sorted;
}

export { IntertextShort, groupBy };
