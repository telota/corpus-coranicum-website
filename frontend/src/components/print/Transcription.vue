<template>
  <Card :title="$t('print_edition.transcription_header')" :informationText="transcriptionInfo">
    <p class="text-2xl px-1 py-5">
      <template v-for="(word, index) in transcription" :key="index">
        <component
          :is="makeLinks ? 'router-link' : 'span'"
          class="cursor-pointer inline-block"
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
        {{ " " }}
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
    transcriptionInfo: String,
    transcription: Array as PropType<Array<string>>,
    selectedWord: Number,
    makeLinks: Boolean,
  },
  emits: ['wordSelected'],
});
</script>
