<template>
  <ArrowNavigation
    :textLeft="$t('navigation.next_verse')"
    :textMiddle="overviewText"
    :textRight="$t('navigation.previous_verse')"
    :leftLink="leftLink"
    :middleLink="middleLink"
    :rightLink="rightLink"
  />
</template>

<script lang="ts">
import { defineComponent, computed, PropType } from 'vue';
import { useRoute, RouteLocationRaw } from 'vue-router';
import ArrowNavigation from '@/components/global/ArrowNavigation.vue';
import { toNextVerse, toPreviousVerse } from '@/components/verse_navigation/verse_navigation_functions';

export default defineComponent({
  components: { ArrowNavigation },
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
  setup(props) {
    const route = useRoute();

    const rightLink = computed(() => toPreviousVerse(route));
    const leftLink = computed(() => toNextVerse(route));

    return {
      rightLink,
      leftLink,
    };
  },
});
</script>
