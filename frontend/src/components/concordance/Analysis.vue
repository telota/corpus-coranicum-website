<template>
  <Card :title="`Analysis ${analysis.analysis}`">
    <ul class="list-disc px-6 py-5">
      <AnalysisItem
        v-for="(value, key) in analysis"
        :key="key + $route.fullPath"
        :name="key"
        :value="value"
        :fullAnalysis='analysis'
      />
    </ul>
  </Card>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import Card from '@/components/global/Card.vue';
import AnalysisItem from '@/components/concordance/AnalysisItem.vue';
import { ConcordanceAnalyis } from '@/interfaces/ConcordanceAnalysis';

export default defineComponent({
  components: { Card, AnalysisItem },
  props: { analysis: Object as PropType<ConcordanceAnalyis> },
});
</script>
