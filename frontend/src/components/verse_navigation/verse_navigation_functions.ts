import { RouteLocationNormalizedLoaded, RouteLocationRaw } from 'vue-router';
import { isLoaded } from '@/interfaces/RemoteData';
import { Verse } from '@/interfaces/Verse';
import { chapters } from '@/api/chapters';

export function nextVerse(sura: number, verse: number): Verse | undefined {
  if (isLoaded(chapters.value)) {
    const currentSura = chapters.value.payload.find((c) => c.key === sura);
    if (currentSura) {
      if (currentSura.verses >= verse + 1) {
        return {
          sura,
          verse: verse + 1,
        };
      }

      if (chapters.value.payload.find((c) => c.key === sura + 1)) {
        return {
          sura: sura + 1,
          verse: 1,
        };
      }
    }
  }
  return undefined;
}
export function previousVerse(sura: number, verse: number): Verse | undefined {
  if (isLoaded(chapters.value)) {
    if (verse > 1) {
      return {
        sura,
        verse: verse - 1,
      };
    }

    const previousSura = chapters.value.payload.find((c) => c.key === sura - 1);
    if (previousSura) {
      return {
        sura: previousSura.key,
        verse: previousSura.verses,
      };
    }
  }
  return undefined;
}

function toVerse(
  route: RouteLocationNormalizedLoaded,
  previous: boolean,
): RouteLocationRaw | undefined {
  let verse: Verse | undefined;
  if (previous) {
    verse = previousVerse(+route.params.sura, +route.params.verse);
  } else {
    verse = nextVerse(+route.params.sura, +route.params.verse);
  }
  if (!verse) {
    return undefined;
  }

  return {
    params: {
      sura: String(verse.sura),
      verse: String(verse.verse),
    },
  };
}
export function toPreviousVerse(
  route: RouteLocationNormalizedLoaded,
): RouteLocationRaw | undefined {
  return toVerse(route, true);
}

export function toNextVerse(route: RouteLocationNormalizedLoaded): RouteLocationRaw | undefined {
  return toVerse(route, false);
}
