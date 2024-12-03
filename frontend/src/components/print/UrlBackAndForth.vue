<template>
  <div class="flex w-full p-2">
    <PlayButton
      class="mr-auto"
      :text="$t('navigation.next_page')"
      arrowType="back"
      :textFirst="false"
      :disabled="!hasNextPage"
      @click="next"
    />
    <PlayButton
      class="ml-auto"
      :text="$t('navigation.previous_page')"
      arrowType="forward"
      :textFirst="true"
      :disabled="!hasPreviousPage"
      @click="previous"
    />
  </div>
</template>
<script lang="ts">
import { computed, defineComponent } from 'vue';
import PlayButton from '@/components/global/PlayButton.vue';
import { nextPage, previousPage } from '@/components/print/cairo_edition_url';

export default defineComponent({
  components: { PlayButton },
  props: {
    imageUrl: {
      type: String,
      required: true,
    },
  },
  emits: ['newImage'],
  setup(props, context) {
    const hasNextPage = computed(() => !!nextPage(props.imageUrl));
    const hasPreviousPage = computed(() => !!previousPage(props.imageUrl));

    function next() {
      if (hasNextPage.value) {
        context.emit('newImage', nextPage(props.imageUrl));
      }
    }

    function previous() {
      if (hasPreviousPage.value) {
        context.emit('newImage', previousPage(props.imageUrl));
      }
    }

    return {
      hasNextPage,
      hasPreviousPage,
      next,
      previous,
    };
  },
});
</script>
