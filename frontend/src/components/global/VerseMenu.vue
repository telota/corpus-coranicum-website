<template>
  <SimpleCard class="w-full block mx-auto mt-4">
    <h2 class="text-center">{{ $t('navigation.verse_menu') }}</h2>
    <VerseSelect />
    <div v-if="route.query.sura && route.query.verse">
      <ManuscriptSelect
        :sura="+route.query.sura"
        :verse="+route.query.verse"
        :justNavigation="false"
        :selected="+route.params.manuscript"
      />
      <ManuscriptPagesForVerse class="pt-4 pb-4" />
      <div class="showLinks">
        {{ $t('navigation.verse_links') }}:
        <router-link
          class="inline-block px-1"
          v-for="link in links"
          :key="link.to.name"
          :to="{
            name: link.to.name,
            params: {
              ...link.to.params,
              sura: $route.query.sura,
              verse: $route.query.verse,
            },
          }"
          >{{ link.label() }}
        </router-link>
      </div>
    </div>
    <div v-else class="text-center">{{ `(${$t('global.no_verse_selected')})` }}</div>
  </SimpleCard>
</template>
<script lang="ts">
import { defineComponent, watch } from 'vue';
import { useRoute } from 'vue-router';
import SimpleCard from '@/components/global/SimpleCard.vue';
import ManuscriptSelect from '@/components/manuscripts/ManuscriptSelect.vue';
import ManuscriptPagesForVerse from '@/components/manuscripts/ManuscriptPagesForVerse.vue';
import VerseSelect from '@/components/verse_navigation/VerseSelect.vue';
import { useI18n } from 'vue-i18n';
import { getManuscriptVerseresults } from '@/api/manuscripts';
import { routeQueryToVerse } from '@/router/route_to_verse';
import { verseLinks } from '../verse_navigation/verse_links';

export default defineComponent({
  components: {
    SimpleCard,
    VerseSelect,
    ManuscriptSelect,
    ManuscriptPagesForVerse,
  },
  setup() {
    const route = useRoute();
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    getManuscriptVerseresults(routeQueryToVerse(route));

    const links = verseLinks(t);
    watch([() => route.query.sura, () => route.query.verse], () => {
      if (route.name === 'ManuscriptSingle' || route.name === 'ManuscriptPage') {
        getManuscriptVerseresults(routeQueryToVerse(route));
      }
    });
    return {
      route,
      links,
    };
  },
});
</script>
