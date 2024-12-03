<template>
  <div class="lg:flex">
    <ArabicTextAndTranscription
      :transcriptionInfo="variantsWeb.payload?.transcription_info"
      :arabicTextInfo="variantsWeb.payload?.arabic_text_info"
      :arabicVerse="arabicVerse"
      :transcription="transcription"
      :selectedWord="selectedWord"
      @wordSelected="setSelectedWord"
      :horizontal="true"
    />
  </div>
</template>
<script lang="ts">
import { computed, defineComponent, PropType, watch } from 'vue';
import { useRoute } from 'vue-router';
import ArabicTextAndTranscription from '@/components/print/ArabicTextAndTranscription.vue';
import { webWatcher, variantsWeb } from '@/api/web';
import { selectedWord, setSelectedWord } from '@/api/variants';
import { VariantsReferenceVerse } from '@/interfaces/VariantsReferenceVerse';

export default defineComponent({
  components: { ArabicTextAndTranscription },
  props: { verse: Object as PropType<VariantsReferenceVerse> },
  setup(props) {
    const route = useRoute();
    webWatcher(route, 'variants', variantsWeb);

    const arabicVerse = computed(() => {
      const verse: string[] = [];
      if (props.verse) {
        Object.values(props.verse).forEach((value) => {
          verse.push(value.arab);
        });
      }
      return verse;
    });
    const transcription = computed(() => {
      const verse: string[] = [];
      if (props.verse) {
        Object.values(props.verse).forEach((value) => {
          verse.push(value.transcription);
        });
      }
      return verse;
    });
    watch([() => route.params.sura, () => route.params.verse], () => {
      setSelectedWord(undefined);
    });

    return {
      variantsWeb,
      selectedWord,
      setSelectedWord,
      arabicVerse,
      transcription,
    };
  },
});
</script>
