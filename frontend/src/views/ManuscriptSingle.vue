<template>
  <VerseMenu />
  <RemoteContent :data="manuscriptDetail">
    <ManuscriptOverview
      v-if="isLoaded(manuscriptDetail)"
      :manuscript="manuscriptDetail.payload"
      class="my-6"
    />
  </RemoteContent>
  <div
    v-if="isLoaded(manuscriptDetail) && $route.name === 'ManuscriptSingle'"
    class="text-center py-6"
  >
    <h3>
      {{ $t('manuscripts.no_page_selected') }}<br />
      {{ $t('manuscripts.no_page_selected_instructions') }}
    </h3>
  </div>
  <router-view></router-view>
  <CatalogueEntry
    v-if="isLoaded(manuscriptDetail)"
    :manuscript="manuscriptDetail.payload"
    class="my-6"
  />
  <HowToQuote v-if="isLoaded(manuscriptWeb)" :citation="manuscriptWeb.payload.how_to_cite" />
</template>
<script lang="ts">
import { defineComponent, computed, watch } from 'vue';
import { useRoute } from 'vue-router';
import { isLoaded } from '@/interfaces/RemoteData';
import { getManuscriptDetail, manuscriptDetail } from '@/api/manuscripts';
import routeParamToString from '@/router/param_as_string';
import ManuscriptOverview from '@/components/manuscripts/ManuscriptOverview.vue';
import CatalogueEntry from '@/components/manuscripts/CatalogueEntry.vue';
import HowToQuote from '@/components/global/HowToQuote.vue';
import RemoteContent from '@/components/global/RemoteContent.vue';
import VerseMenu from '@/components/global/VerseMenu.vue';
import ManuscriptPagesForVerse from '@/components/manuscripts/ManuscriptPagesForVerse.vue';
import { manuscriptWeb, webWatcher } from '@/api/web';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';
import SimpleCard from '@/components/global/SimpleCard.vue';

export default defineComponent({
  components: {
    ManuscriptOverview,
    CatalogueEntry,
    HowToQuote,
    RemoteContent,
    VerseMenu,
    // SimpleCard,
  },
  setup() {
    const route = useRoute();
    webWatcher(route, 'manuscripts', manuscriptWeb);
    getManuscriptDetail(+routeParamToString(route.params.manuscript));

    watch([() => route.params.manuscript], () => {
      if (route.name === 'ManuscriptPage' || route.name === 'ManuscriptSingle') {
        getManuscriptDetail(+routeParamToString(route.params.manuscript));
      }
    });

    return {
      manuscriptDetail,
      isLoaded,
      manuscriptWeb,
    };
  },
});
</script>
