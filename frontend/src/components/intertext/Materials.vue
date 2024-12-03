<template>
  <SectionHeader :title="intertext.title" />
  <TwoItems>
    <template v-slot:first>
      <IntertextImages v-if="intertext.images.length > 0" :images="intertext.images" />
      <ScrollCard
        v-if="intertext.content"
        :title="$t('intertext.original_language')"
        :informationText="intertextWeb.payload?.original_info"
        :htmlContent="intertext.content"
        :direction="intertext.content_direction"
        class="text-wrap text-xl"
      />
      <ScrollCard
        v-if="intertext.transcription"
        :title="$t('print_edition.transcription_header')"
        :informationText="intertextWeb.payload?.transcription_info"
        :htmlContent="intertext.transcription"
      />
    </template>
    <template v-slot:second>
      <Translations
        :translations="intertext.translations"
        :germanSource="intertext.translation_source"
      />
    </template>
  </TwoItems>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import ScrollCard from '@/components/global/ScrollCard.vue';
import SectionHeader from '@/components/global/SectionHeader.vue';
import Translations from '@/components/intertext/Translations.vue';
import IntertextImages from '@/components/intertext/Images.vue';
import TwoItems from '@/components/global/TwoItems.vue';
import { intertextWeb } from '@/api/web';
import { IntertextDetail } from '@/interfaces/IntertextDetail';

export default defineComponent({
  components: {
    SectionHeader,
    TwoItems,
    IntertextImages,
    ScrollCard,
    Translations,
  },
  props: { intertext: Object as PropType<IntertextDetail> },
  setup() {
    return { intertextWeb };
  },
});
</script>
