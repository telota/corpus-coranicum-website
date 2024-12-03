<template>
  <div class="cursor-pointer px-3 py-1">
    <p v-if="compare(r.start, r.end) === 0">
      Verse {{ `${r.start.sura}:${r.start.verse}` }}
    </p>
    <p v-else>
      Verses
      {{ `${r.start.sura}:${r.start.verse}-${r.end.sura}:${r.end.verse}` }}
    </p>
  </div>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { VerseRange } from '@/interfaces/VerseRange';
import { compare } from '@/interfaces/Verse';

export default defineComponent({
  props: { r: Object as PropType<VerseRange> },
  setup() {
    return { compare };
  },
});
</script>
