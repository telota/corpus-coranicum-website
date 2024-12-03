<template>
  <div class="flex w-full">
    <PlayButton
      class="mr-auto"
      :text="leftText"
      arrowType="back"
      :textFirst="false"
      :disabled="hasNextVerse"
      :internalLink="backLink"
    />
    <PlayButton
      class="ml-auto"
      :text="$t('navigation.previous_verse')"
      arrowType="forward"
      :textFirst="true"
      :disabled="hasPreviousVerse"
      :internalLink="forwardLink"
    />
  </div>
</template>
<script lang="ts">
import { defineComponent, computed } from 'vue';
import { useRoute } from 'vue-router';
import PlayButton from '@/components/global/PlayButton.vue';
import { toNextVerse, toPreviousVerse, nextVerse, previousVerse } from '@/components/verse_navigation/verse_navigation_functions';

export default defineComponent({
  components: { PlayButton },
  setup() {
    const route = useRoute();

    const forwardLink = computed(() => toPreviousVerse(route));
    const backLink = computed(() => toNextVerse(route));
    const hasNextVerse = computed(
      () => !nextVerse(+route.params.sura, +route.params.verse),
    );
    const hasPreviousVerse = computed(
      () => !previousVerse(+route.params.sura, +route.params.verse),
    );
    return {
      forwardLink,
      backLink,
      hasNextVerse,
      hasPreviousVerse,
    };
  },
});
</script>
