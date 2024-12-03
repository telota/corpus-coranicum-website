import { Verse } from '@/interfaces/Verse';
import { RouteLocationNormalizedLoaded, Router } from 'vue-router';

function parseVerse(s: string): null | Verse {
  const split = s.split(':');
  if (split.length !== 2) {
    return null;
  }
  return {
    sura: parseInt(split[0], 10),
    verse: parseInt(split[1], 10),
  };
}
function createLinks(router: Router, currentRoute: RouteLocationNormalizedLoaded): void {
  const elements = document.querySelectorAll('[data-type]');
  elements.forEach((el) => {
    const htmlElement = el as HTMLAnchorElement;
    let route = currentRoute;

    if (htmlElement.dataset.start && parseVerse(htmlElement.dataset.start)) {
      const verse = parseVerse(htmlElement.dataset.start);

      const params = {
        lang: currentRoute.params.lang,
        sura: verse?.sura,
        verse: verse?.verse === 0 ? 1 : verse?.verse,
      };

      if (htmlElement.dataset.type === 'koran') {
        route = router.resolve({
          name: 'VerseCommentary',
          params,
          hash: '#text',
        });
      } else if (htmlElement.dataset.type === 'lesarten') {
        route = router.resolve({
          name: 'VerseVariants',
          params,
        });
      } else if (
        htmlElement.dataset.type === 'handschrift'
        || htmlElement.dataset.type === 'handschriften'
      ) {
        route = router.resolve({
          name: 'ManuscriptSingle',
          params: {
            ...params,
            manuscript: htmlElement.dataset.id,
          },
        });
      } else {
        route = router.resolve({
          name: 'VerseCommentary',
          params,
          hash: `#${htmlElement.dataset.type}`,
        });
      }
    }

    if (htmlElement.dataset.type === 'intertext' && htmlElement.dataset.id) {
      route = router.resolve({
        name: 'VerseIntertextDetail',
        params: {
          lang: currentRoute.params.lang,
          sura: currentRoute.params.sura,
          verse: currentRoute.params.verse,
          id: parseInt(htmlElement.dataset.id, 10),
        },
      });
    }

    htmlElement.href = route.fullPath;
    htmlElement.addEventListener('click', (e) => {
      e.preventDefault();
      router.push(route);
    });
  });
}

export { parseVerse, createLinks };
