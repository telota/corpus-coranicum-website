<template>
<VerseBar :overviewText="$t('navigation.link_overview_intertexts')"
:middleLink="{ name: 'IntertextsOverview' }" />
  <div v-if="isLoaded(intertextVerseResults)">
    <h3 class="text-center py-5">
      <template v-if="intertextVerseResults.payload.length == 1">
        {{
          $t('intertext.result_description_singular', {
            count: intertextVerseResults.payload.length,
            sura: $route.params.sura,
            verse: $route.params.verse,
          })
        }}
      </template>
      <template v-else>
        {{
          $t('intertext.result_description_plural', {
            count: intertextVerseResults.payload.length,
            sura: $route.params.sura,
            verse: $route.params.verse,
          })
        }}
      </template>
    </h3>
    <Summary v-for="r in sorted" :key="r.title" :intertext="r"></Summary>
  </div>
</template>
<script lang="ts">
import { defineComponent, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { routeParamsToVerse } from '@/router/route_to_verse';
import { isLoaded } from '@/interfaces/RemoteData';
import { getIntertextResults, intertextVerseResults } from '@/api/intertext';
import VerseBar from '@/components/verse_navigation/VerseBackAndForth.vue';
import Summary from '@/components/intertext/Summary.vue';
import { compareByTitle, IntertextSummary } from '@/interfaces/IntertextSummary';

export default defineComponent({
  components: {
    VerseBar,
    Summary,
  },
  setup() {
    const route = useRoute();
    getIntertextResults(routeParamsToVerse(route.params));
    const sorted = ref<IntertextSummary[]>([]);

    function sortByTitle() {
      if (isLoaded(intertextVerseResults.value)) {
        sorted.value = intertextVerseResults.value.payload.slice();
        sorted.value.sort(compareByTitle);
      }
    }

    sortByTitle();

    watch([() => route.params], () => {
      if (route.name === 'VerseIntertextResults') {
        getIntertextResults(routeParamsToVerse(route.params));
      }
    });

    watch(intertextVerseResults, () => {
      sortByTitle();
    });

    return {
      intertextVerseResults,
      sorted,
      isLoaded,
    };
  },
});
</script>
