<template>
  <Card :title="$t('print_edition.corcordance_analysis')" :informationText="transcriptionInfo">
    <div v-if="typeof selectedWord !== 'undefined'" class="p-5">
      <p
        class="break-all"
        v-for="analysis in analyses"
        :key="analysis"
      >
        {{ analysis }}
      </p>
      <SmallButton class="bg-green-200 mt-3 block ml-auto mr-0">
        <router-link
          :to="{
            name: 'VerseConcordance',
            params: { word: selectedWord + 1 },
          }"
        >
          {{ $t('print_edition.to_concordance') }}
        </router-link>
      </SmallButton>
    </div>
    <p v-else class="p-3">{{ $t('print_edition.parse_message') }}</p>
  </Card>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import Card from '@/components/global/Card.vue';
import SmallButton from '@/components/global/SmallButton.vue';

export default defineComponent({
  components: {
    Card, SmallButton,
  },
  props: {
    transcriptionInfo: String,
    selectedWord: {
      type: Number,
      required: false,
    },
    analyses: Array as PropType<Array<string>>,
  },
});
</script>
