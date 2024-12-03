<template>
  <ArrowNavigation
    :textLeft="$t('navigation.next_sura')"
    :textRight="$t('navigation.previous_sura')"
    :leftLink="nextSura"
    :rightLink="previousSura"
    :textMiddle="overviewText"
    :middleLink="middleLink"
  >
  </ArrowNavigation>
</template>
<script lang="ts">
import { defineComponent, computed, PropType } from 'vue';
import { useRoute, RouteLocationRaw } from 'vue-router';
import ArrowNavigation from '@/components/global/ArrowNavigation.vue';
import { isLoaded } from '@/interfaces/RemoteData';

export default defineComponent({
  components: {
    ArrowNavigation,
  },
  props: {
    overviewText: {
      type: String as PropType<string>,
      required: true,
    },
    middleLink: {
      type: Object as PropType<RouteLocationRaw>,
      required: true,
    },
  },
  setup() {
    const route = useRoute();
    const maxSura = 114;
    const nextSura = computed(() => {
      if (+route.params.sura < maxSura) {
        return {
          params: {
            sura: +route.params.sura + 1,
            verse: 1,
          },
        };
      }
      return undefined;
    });
    const previousSura = computed(() => {
      if (+route.params.sura > 1) {
        return {
          params: {
            sura: +route.params.sura - 1,
            verse: 1,
          },
        };
      }

      return undefined;
    });

    return {
      isLoaded,
      previousSura,
      nextSura,
    };
  },
});
</script>
