<template>
  <Card :title="$t('print_edition.arabic_header')" :informationText="arabicTextInfo">
    <p class="arabic text-4xl px-1 py-5 flex flex-row flex-wrap"
    style="line-height: 1.5;">
      <template v-for="(word, index) in arabicVerse" :key="index">
        <component
          :is="makeLinks ? 'router-link' : 'span'"
          class="cursor-pointer hover:no-underline"
          :class="index == selectedWord ? 'bg-green-500 text-white' : ''"
          @click="$emit('wordSelected', index)"
          :to="
            makeLinks
              ? {
                  name: 'VerseConcordance',
                  params: { word: index + 1 },
                }
              : null
          "
          >{{ word }}</component
        >
        {{ '\xa0' }}
      </template>
    </p>
  </Card>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import Card from '@/components/global/Card.vue';

export default defineComponent({
  components: { Card },
  props: {
    arabicTextInfo: String,
    arabicVerse: Array as PropType<Array<string>>,
    selectedWord: Number,
    makeLinks: Boolean,
  },
  emits: ['wordSelected'],
});
</script>
