<template>
  <SectionHeader :infoText="concordanceWeb.payload?.talmon_info">
  <template v-slot:title>
    <span v-html="$t('concordance.concordance_header')"></span>
  </template>
  <template v-slot:subtitle>
  <span v-html="`${$t('global.sura')} ${$route.params.sura} ${$t('global.verse')}
  ${$route.params.verse} ${$t('global.word')} ${$route.params.word}`"></span>
</template>
</SectionHeader>
<div class="flex justify-center w-full my-2">
<router-link :to="{ name: 'ConcordanceOverview' }">
      <PrimaryButton class="w-72 mb-2">
        {{ $t('concordance.to_overview') }}
      </PrimaryButton>
    </router-link>
</div>
  <WordDisplay
    :arabicVerse="arabicVerse"
    :transcription="transcription"
    class="max-w-screen-md mx-auto my-6"
  />
  <TwoItems>
    <template v-slot:first
      ><Transcription
        :transcriptionInfo="concordanceWeb.payload?.transcription_info"
        :transcription="transcription"
        :selectedWord="+$route.params.word - 1"
        :makeLinks="true"
    /></template>

    <template v-slot:second
      ><ArabicText
        :arabicTextInfo="concordanceWeb.payload?.arabic_text_info"
        :arabicVerse="arabicVerse"
        :selectedWord="+$route.params.word - 1"
        :makeLinks="true"
    /></template>
  </TwoItems>

  <SectionHeader
    :title="$t('concordance.analysis_heading')"
    :infoText="concordanceWeb.payload?.analysis_info"
  />
  <Analysis
    v-for="analysis in concordanceData.payload?.analyses"
    :key="analysis.analysis"
    :analysis="analysis"
  />
  <HowToQuote v-if="isLoaded(concordanceWeb)" :citation="concordanceWeb.payload.how_to_cite" />
</template>
<script lang="ts">
import { computed, defineComponent, ref, Ref, watch, watchEffect } from 'vue';
import { useRoute } from 'vue-router';
import SectionHeader from '@/components/global/SectionHeader.vue';
import ArabicText from '@/components/print/ArabicText.vue';
import WordDisplay from '@/components/concordance/WordDisplay.vue';
import TwoItems from '@/components/global/TwoItems.vue';
import Analysis from '@/components/concordance/Analysis.vue';
import routeParamToString from '@/router/param_as_string';
import { concordanceData,
  getConcordanceData,
  getWordReferences,
  getReferences,
  wordRefs,
  baseRefs,
  rootRefs } from '@/api/concordance';
import { isLoaded } from '@/interfaces/RemoteData';
import { webWatcher, concordanceWeb } from '@/api/web';
import Transcription from '@/components/print/Transcription.vue';
import HowToQuote from '@/components/global/HowToQuote.vue';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';
import PrimaryButton from '@/components/global/PrimaryButton.vue';

export default defineComponent({
  components: {
    SectionHeader,
    WordDisplay,
    TwoItems,
    Analysis,
    ArabicText,
    Transcription,
    HowToQuote,
    PrimaryButton,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();
    const title = computed(
      () => `${t('navigation.concordance')} ${t('global.sura')} ${route.params.sura} ${t(
        'global.verse',
      )} ${route.params.verse} ${t('global.word')} ${route.params.word}`,
    );
    const description = computed(
      () => `${t('navigation.concordance')} ${t('global.sura')} ${route.params.sura} ${t(
        'global.verse',
      )} ${route.params.verse} ${t('global.word')} ${route.params.word}`,
    );
    const canonicalurl = computed(
      () => `https://corpuscoranicum.de/${route.params.lang}/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/concordance/word/${route.params.word}`,
    );
    const alternate_de = computed(
      () => `https://corpuscoranicum.de/de/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/concordance/word/${route.params.word}`,
    );
    const alternate_en = computed(
      () => `https://corpuscoranicum.de/en/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/concordance/word/${route.params.word}`,
    );
    const alternate_fr = computed(
      () => `https://corpuscoranicum.de/fr/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/concordance/word/${route.params.word}`,
    );
    const meta = computed(() => ({
      title: title.value,
      description: description.value,
      link: [
        { rel: 'canonical', href: canonicalurl.value },
        { rel: 'alternate', hreflang: 'de', href: alternate_de.value },
        { rel: 'alternate', hreflang: 'en', href: alternate_en.value },
        { rel: 'alternate', hreflang: 'fr', href: alternate_fr.value },
        { rel: 'alternate', hreflang: 'x-default', href: alternate_de.value },
      ],
      htmlAttrs: {
        lang: route.params.lang,
      },
    }));
    useMeta(meta);
    webWatcher(route, 'concordance', concordanceWeb);
    const lang = routeParamToString(route.params.lang);
    getConcordanceData(lang, +route.params.sura, +route.params.verse, +route.params.word);
    watch([() => route.params.sura, () => route.params.verse, () => route.params.word], () => {
      if (route.name === 'VerseConcordance') {
        getConcordanceData(
          routeParamToString(route.params.lang),
          +route.params.sura,
          +route.params.verse,
          +route.params.word,
        );
      }
    });

    watch(concordanceData, () => {
      getWordReferences();
      getReferences('base_cc');
      getReferences('root_cc');
    });

    const arabicVerse: Ref<string[]> = ref([]);
    const transcription: Ref<string[]> = ref([]);

    watchEffect(() => {
      if (isLoaded(concordanceData.value) && isLoaded(concordanceWeb.value)) {
        arabicVerse.value = concordanceData.value.payload.arabic_text.slice();
        transcription.value = concordanceData.value.payload.transcription_text.slice();
      }
    });

    return {
      concordanceWeb,
      concordanceData,
      arabicVerse,
      transcription,
      wordRefs,
      baseRefs,
      rootRefs,
      isLoaded,
    };
  },
});
</script>
