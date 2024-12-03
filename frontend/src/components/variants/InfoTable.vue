<template>
  <p class="whitespace-normal">
    {{ `${reader ? reader.name : ''}${work ? work.name : ''}` }}
  </p>
  <p v-if="work" class="whitespace-normal">
    {{ `${$t('variants.death_year')}: ${work.death_year}n.Chr./${work.death_year_arabic}AH` }}
  </p>
  <p v-if="reader && reader.death_year" class="whitespace-normal">
    {{ `${$t('variants.death_year')}: ${reader.death_year}${$t('variants.ce')}` }}
    <span v-if="reader.death_year_arabic" class="whitespace-normal">
      {{ ` /${reader.death_year_arabic}${$t('variants.ah')}` }}
    </span>
  </p>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { VariantsReader } from '@/interfaces/VariantsReader';
import { VariantsWork } from '@/interfaces/VariantsWork';

export default defineComponent({
  props: {
    work: Object as PropType<VariantsWork | undefined>,
    reader: Object as PropType<VariantsReader | undefined>,
  },
});
</script>
