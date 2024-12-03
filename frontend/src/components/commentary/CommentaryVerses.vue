<template>
  <p class="font-bold" :id="commentaryVersesId(sectionId, commentary)">
    {{ commentaryVersesTitle(commentary) }}
  </p>
  <div class="pb-6" v-html="commentary.content" />
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { CommentaryVerses,
  commentaryVersesId,
  commentaryVersesTitle } from '@/interfaces/CommentaryVerses';

export default defineComponent({
  props: {
    commentary: Object as PropType<CommentaryVerses>,
    sectionId: String,
  },
  setup() {
    return {
      commentaryVersesTitle,
      commentaryVersesId,
    };
  },
});
</script>
