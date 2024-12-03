<template>
  <div>
    <h2 class="text-center">{{ $t('manuscripts.reference_text') }}</h2>
    <h3 v-if="typeof verses === 'string'" class="text-center">
      ({{ $t('global.verse_range_too_large') }})
    </h3>
    <TwoItems v-else>
      <template v-slot:first>
        <ScrollCard
          :title="$t('print_edition.arabic_header')"
          :informationText="manuscriptWeb.payload?.arabic_text_info"
        >
          <p v-for="v in verses" :key="v.arabic" class="arabic" dir="rtl">
            <sup class="pl-1">{{ `${v.sura}:${v.verse}` }}</sup>
            <span class="arabic text-2xl">{{ v.arabic }}</span>
          </p>
        </ScrollCard>
      </template>
      <template v-slot:second>
        <ScrollCard
          :title="$t('print_edition.translation_header')"
          :informationText="manuscriptWeb.payload?.translation_info"
        >
          <p v-for="v in verses" :key="v.translation">
            <sup class="pr-1">{{ `${v.sura}:${v.verse}` }}</sup>
            <span>{{ v.translation }}</span>
          </p>
        </ScrollCard>
      </template>
    </TwoItems>
  </div>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { VerseTranslation } from '@/interfaces/VerseTranslaton';
import ScrollCard from '@/components/global/ScrollCard.vue';
import TwoItems from '@/components/global/TwoItems.vue';
import { manuscriptWeb } from '@/api/web';

export default defineComponent({
  components: {
    TwoItems,
    ScrollCard,
  },
  props: { verses: Object as PropType<Array<VerseTranslation> | string> },
  setup() {
    return { manuscriptWeb };
  },
});
</script>
