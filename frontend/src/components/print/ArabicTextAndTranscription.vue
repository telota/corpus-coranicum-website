<template>
   <ArabicText
        :arabicTextInfo="arabicTextInfo"
        :arabicVerse="arabicVerse"
        :selectedWord="selectedWord"
        @wordSelected="$emit('wordSelected', $event)"
        class="pr-3"
      />

      <Transcription
        :transcriptionInfo="transcriptionInfo"
        :transcription="transcription"
        :selectedWord="selectedWord"
        @wordSelected="$emit('wordSelected', $event)"
        class="pl-3"
      />
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import Transcription from '@/components/print/Transcription.vue';
import ArabicText from '@/components/print/ArabicText.vue';

export default defineComponent({
  components: {
    ArabicText,
    Transcription,
  },
  props: {
    arabicTextInfo: String,
    transcriptionInfo: String,
    arabicVerse: Array as PropType<Array<string>>,
    transcription: Array as PropType<Array<string>>,
    selectedWord: Number,
    makeLinks: Boolean,
    horizontal: Boolean,
  },
  emits: ['wordSelected'],
});
</script>
