<template>
  <ArrowNavigation
    :textLeft="$t('navigation.next_page')"
    :textRight="$t('navigation.previous_page')"
    :leftLink="nextPage"
    :rightLink="previousPage"
  >
    <h2 class="text-center">
      {{ `${$t('manuscripts.folio_and_page')} ${$route.params.page}` }}
    </h2>
  </ArrowNavigation>
</template>
<script lang="ts">
import { computed, defineComponent } from 'vue';
import { RouteLocationRaw, useRoute } from 'vue-router';
import ArrowNavigation from '@/components/global/ArrowNavigation.vue';
import { manuscriptDetail } from '@/api/manuscripts';
import { isLoaded } from '@/interfaces/RemoteData';
import routeParamToString from '@/router/param_as_string';

export default defineComponent({
  components: { ArrowNavigation },
  setup() {
    const route = useRoute();
    const currentPageIndex = computed(() => {
      if (isLoaded(manuscriptDetail.value) && route.params.page) {
        const page = routeParamToString(route.params.page);
        return manuscriptDetail.value.payload.pages.findIndex((p) => p.folio + p.side === page);
      }
      return undefined;
    });

    const nextPage = computed(() => {
      if (isLoaded(manuscriptDetail.value)) {
        const pageCount = manuscriptDetail.value.payload.pages.length;

        if (currentPageIndex.value !== undefined && currentPageIndex.value < pageCount - 1) {
          const newPage = manuscriptDetail.value.payload.pages[currentPageIndex.value + 1];

          const nextRoute: RouteLocationRaw = {
            params: { page: newPage.folio + newPage.side },
            query: route.query,
            hash: '#manuscript_page',
          };
          return nextRoute;
        }
        return undefined;
      }
      return undefined;
    });

    const previousPage = computed(() => {
      if (isLoaded(manuscriptDetail.value)) {
        if (currentPageIndex.value && currentPageIndex.value > 0) {
          const newPage = manuscriptDetail.value.payload.pages[currentPageIndex.value - 1];

          const nextRoute: RouteLocationRaw = {
            params: { page: newPage.folio + newPage.side },
            query: route.query,
            hash: '#manuscript_page',
          };
          return nextRoute;
        }
        return undefined;
      }
      return undefined;
    });

    return {
      nextPage,
      previousPage,
      currentPageIndex,
    };
  },
});
</script>
