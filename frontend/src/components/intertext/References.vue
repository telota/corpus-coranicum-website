<template>
  <SectionHeader :title="$t('intertext.references')" />
  <TwoItems class="showLinks">
    <template v-slot:first>
      <CommentaryMentions />
      <Metadata />
    </template>
    <template v-slot:second>
      <QuranPassages />
    </template>
  </TwoItems>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import SectionHeader from '@/components/global/SectionHeader.vue';
import TwoItems from '@/components/global/TwoItems.vue';
import Metadata from '@/components/intertext/Metadata.vue';
import QuranPassages from '@/components/intertext/QuranPassages.vue';
import CommentaryMentions from './CommentaryMentions.vue';

export default defineComponent({
  components: {
    SectionHeader,
    TwoItems,
    QuranPassages,
    Metadata,
    CommentaryMentions,
  },
});
</script>
