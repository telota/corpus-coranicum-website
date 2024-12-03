<template>
  <ul class="list-disc pl-6 bg-white">
    <li v-for="(verse, index) in verses" :key="index" class="leading-6 py-1">
      <router-link
        :to="{
          name: 'VerseConcordance',
          params: {
            sura: verse.sura,
            verse: verse.verse,
            word: verse.word,
          },
        }"
        v-html="verse.transcription_text[0]"
      >
      </router-link>
    </li>
  </ul>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { ConcordanceVerse } from '@/interfaces/ConcordanceVerse';

export default defineComponent({ props: { verses: Array as PropType<Array<ConcordanceVerse>> } });
</script>
