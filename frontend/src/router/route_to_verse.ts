import { RouteLocationNormalizedLoaded, RouteParams } from 'vue-router';
import { Verse } from '@/interfaces/Verse';

function routeParamsToVerse(params: RouteParams): Verse {
  const sura = +params.sura;
  const verse = +params.verse;
  return {
    sura,
    verse,
  };
}

function routeQueryToVerse(route: RouteLocationNormalizedLoaded): Verse {
  if (route.query.sura && route.query.verse) {
    return {
      sura: +route.query.sura,
      verse: +route.query.verse,
    };
  }
  return {
    sura: 0,
    verse: 0,
  };
}

function determineVerse(route: RouteLocationNormalizedLoaded): Verse {
  if (route.params.sura && route.params.verse) {
    return {
      sura: +route.params.sura,
      verse: +route.params.verse,
    };
  }
  if (route.query.sura && route.query.verse) {
    return {
      sura: +route.query.sura,
      verse: +route.query.verse,
    };
  }
  return {
    sura: 0,
    verse: 0,
  };
}

function routeParamsToVerseKey(params: RouteParams): string {
  return `${params.sura}:${params.verse}`;
}

export { determineVerse, routeParamsToVerse, routeQueryToVerse, routeParamsToVerseKey };
