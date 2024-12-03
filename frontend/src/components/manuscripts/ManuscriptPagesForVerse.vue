<template>
  <p>
    <span class="text-center">
      {{
        `${$t('manuscripts.pages_for_verse', {
          sura: $route.query.sura,
          verse: $route.query.verse,
        })}: `
      }}
    </span>
    <span v-if="pagesForVerse.length > 0" class="text-center py-2 showLinks">
      <router-link
        class="px-2"
        v-for="p in pagesForVerse"
        :key="p.folio + p.side"
        :to="{
          name: 'ManuscriptPage',
          params: { page: p.folio + p.side },
          query: $route.query,
          hash: '#manuscript_page',
        }"
        >{{ p.folio + p.side }}</router-link
      >
    </span>
    <span v-else-if="isLoaded(manuscriptDetail)" class="text-center py-4">{{
      $t('manuscripts.none')
    }}</span>
  </p>
</template>
<script lang="ts">
import { computed, defineComponent, ref } from 'vue';
import { useRoute } from 'vue-router';
import { verseInRange, VerseRange } from '@/interfaces/VerseRange';
import { Verse } from '@/interfaces/Verse';
import { routeQueryToVerse } from '@/router/route_to_verse';
import { manuscriptDetail } from '@/api/manuscripts';
import { isLoaded } from '@/interfaces/RemoteData';

export default defineComponent({
  setup() {
    const route = useRoute();
    const pagesForVerse = computed(() => {
      const routeVerse = ref<Verse>(routeQueryToVerse(route));
      if (isLoaded(manuscriptDetail.value)) {
        const { pages } = manuscriptDetail.value.payload;
        return pages.filter((page) => page.passages.some((passage) => {
          const range: VerseRange = {
            start: {
              sura: passage.start.sura,
              verse: passage.start.verse,
            },
            end: {
              sura: passage.end.sura,
              verse: passage.end.verse,
            },
          };
          return verseInRange(routeVerse.value)(range);
        }));
      }
      return [];
    });

    return {
      pagesForVerse,
      manuscriptDetail,
      isLoaded,
    };
  },
});
</script>
