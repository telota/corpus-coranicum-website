<template>
  <div class="pt-10 text-2xl">
    <h3 class="text-center">Editors and Contributors</h3>
    <p>Michael Marx (editor in chief)</p>
    <p>
      Variant readings of the Qurʾān (qirāʾāt) are listed for
      Q {{ $route.params.sura }}:{{ $route.params.verse }} in
      Latin transcription from the following
      sources:
    </p>
    <ul class="list-disc pl-6">
      <li v-for="c in contributions" :key="c.source">
        {{ c.source }} {{ contributorsString(c.contributors) }}
      </li>
    </ul>
  </div>
</template>
<script lang="ts">
import { contributorsString, VariantsContribution } from '@/interfaces/VariantsContribution';
import { defineComponent, PropType } from 'vue';

export default defineComponent({
  props: {
    contributions: Array as PropType<Array<VariantsContribution>>,
  },
  setup() {
    return {
      contributorsString,
    };
  },
});
</script>
