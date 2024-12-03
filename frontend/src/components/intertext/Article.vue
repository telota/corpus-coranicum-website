<template>
  <ArticleContainer>
    <h2 class="pb-6">{{ intertext.title }}</h2>
    <InfoTable :intertext="intertext" />
    <ArticleSection>
      <h3 class="pt-3">{{ `${$t('intertext.editor')}: ${intertext.entry_author}` }}</h3>
      <div v-html="intertext.notes" class="showLinks spaceParagraphs" />
    </ArticleSection>
    <ArticleSection>
      <h3 class="">{{ $t('manuscripts.literature') }}</h3>
      <LiteratureInfoTable :intertext="intertext" />
      <h4 v-if="intertext.literature" class="py-2">
        {{ $t('intertext.additional_sources') }}
      </h4>
      <div
        v-if="intertext.literature"
        v-html="intertext.literature"
        class="showLinks spaceParagraphsSmall"
      />
    </ArticleSection>
    <ArticleSection>
      <HowToQuote
        v-if="isLoaded(intertextWeb)"
        :citation="intertextWeb.payload.how_to_cite"
        :precitation="precitation"
      />
    </ArticleSection>
  </ArticleContainer>
</template>
<script lang="ts">
import { computed, defineComponent, PropType } from 'vue';
import { IntertextDetail } from '@/interfaces/IntertextDetail';
import ArticleSection from '@/components/global/ArticleSection.vue';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import { intertextWeb } from '@/api/web';
import { isLoaded } from '@/interfaces/RemoteData';
import LiteratureInfoTable from '@/components/intertext/LiteratureInfoTable.vue';
import InfoTable from './InfoTable.vue';
import HowToQuote from '../global/HowToQuote.vue';

export default defineComponent({
  components: {
    InfoTable,
    ArticleContainer,
    ArticleSection,
    HowToQuote,
    LiteratureInfoTable,
  },
  props: {
    intertext: Object as PropType<IntertextDetail>,
    precitation: String,
  },
  setup() {
    return {
      intertextWeb,
      isLoaded,
    };
  },
});
</script>
