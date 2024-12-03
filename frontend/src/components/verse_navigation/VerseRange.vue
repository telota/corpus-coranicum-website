<template>
  <span v-if="JSON.stringify(range.start) === JSON.stringify(range.end)"
    >Verse {{ range.start.sura }}:{{ range.start.verse }}</span
  >
  <span v-else
    >Verses {{ range.start.sura }}:{{ range.start.verse }} -
    {{ range.end.sura }}:{{ range.end.verse }}
  </span>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { VerseRange } from '@/interfaces/VerseRange';

export default defineComponent({ props: { range: Object as PropType<VerseRange> } });
</script>
