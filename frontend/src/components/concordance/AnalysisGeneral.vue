<template>
  <Card> TODO </Card>
</template>
<script lang="ts">
import { ConcordanceAnalyis } from '@/interfaces/ConcordanceAnalysis';
import { defineComponent, PropType } from 'vue';

export default defineComponent({
  props: { analysis: Object as PropType<ConcordanceAnalyis> },
  setup() {
    console.log('Working on it');
  },
});
</script>
