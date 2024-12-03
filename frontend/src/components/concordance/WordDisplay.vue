<template>
  <div class="p-6 text-center bg-white">
    <label class="text-2xl" for="wort_select">
      {{
        $t('concordance.select', {
          sura: $route.params.sura,
          verse: $route.params.verse,
        })
      }}
    </label>
    <select
      class="ml-2 text-2xl bg-green-200 border"
      id="word_select"
      v-model="selected"
      @change="navigate"
    >
      <option
        v-for="(word, index) in arabicVerse"
        :key="index"
        :value="index + 1"
      >
        {{ `${index + 1}: ${transcription[index]}` }}
      </option>
    </select>
  </div>
</template>
<script lang="ts">
import { defineComponent, PropType, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default defineComponent({
  props: {
    arabicVerse: Array as PropType<Array<string>>,
    transcription: Array as PropType<Array<string>>,
  },
  setup() {
    const route = useRoute();
    const router = useRouter();
    const selected = ref<number>(+route.params.word);

    watch([() => route.params.word], () => {
      selected.value = +route.params.word;
    });

    function navigate() {
      router.push({ params: { word: selected.value } });
    }

    return {
      selected,
      navigate,
    };
  },
});
</script>
