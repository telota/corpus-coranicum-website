<template>
<SectionHeader :infoText="printWeb.payload?.introduction_general">
  <template v-slot:title>
    <span v-html="$t('print_edition.page_title')"></span>
  </template>
  <template v-slot:subtitle>
  <span v-html="`${$t('global.sura')} ${$route.params.sura} ${$t('global.verse')}
  ${$route.params.verse}`"></span>
</template>
</SectionHeader>
<VerseBar :overviewText="$t('navigation.link_overview_print')"
:middleLink="{ name: 'PrintEditionOverview' }" />
  <RemoteContent :data="printData">
  <div class="lg:flex" v-if="isLoaded(printData)">
    <CairoQuran />
    <div class="lg:pl-3 flex-grow w-full">
      <ArabicText
        :arabicTextInfo="printWeb.payload?.arabic_text_info"
        :arabicVerse="printData.payload.arabic_text"
        :selectedWord="selectedWord"
        @wordSelected="selectedWord = $event"
      />

      <Transcription
        :transcriptionInfo="printWeb.payload?.transcription_info"
        :transcription="printData.payload.transcription_text"
        :selectedWord="selectedWord"
        @wordSelected="selectedWord = $event"
      />
      <WordAnalysis
        :transcriptionInfo="printWeb.payload?.morphology_info"
        :selectedWord="selectedWord"
        :analyses="printData.payload.transcription_analysis[selectedWord]"
      />
      <Card
        :title="$t('print_edition.translation_header')"
        :informationText="printWeb.payload?.translation_info"
      >
        <p class="text-2xl p-3">{{ printData.payload.translation }}</p>
      </Card>
    </div>
  </div>
  <HowToQuote v-if="isLoaded(printWeb)" :citation="printWeb.payload.how_to_cite" />
  </RemoteContent>
</template>
<script lang="ts">
import { defineComponent, watch, ref, Ref, computed } from 'vue';
import { useRoute } from 'vue-router';
import { getCairoPages, getPrintData, printData } from '@/api/print_edition';
import { webWatcher, printWeb } from '@/api/web';
import { isLoaded } from '@/interfaces/RemoteData';
import routeParamToString from '@/router/param_as_string';
import SectionHeader from '@/components/global/SectionHeader.vue';
import RemoteContent from '@/components/global/RemoteContent.vue';
import VerseBar from '@/components/verse_navigation/VerseBackAndForth.vue';
import WordAnalysis from '@/components/print/WordAnalysis.vue';
import Card from '@/components/global/Card.vue';
import Transcription from '@/components/print/Transcription.vue';
import ArabicText from '@/components/print/ArabicText.vue';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';
import CairoQuran from '@/components/print/CairoQuran.vue';
import HowToQuote from '@/components/global/HowToQuote.vue';

export default defineComponent({
  components: {
    SectionHeader,
    VerseBar,
    Card,
    WordAnalysis,
    ArabicText,
    Transcription,
    CairoQuran,
    HowToQuote,
    RemoteContent,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();

    const title = computed(
      () => `${t('navigation.print_edition')} ${t('global.sura')} ${route.params.sura} ${t(
        'global.verse',
      )} ${route.params.verse}`,
    );
    const description = computed(
      () => `${t('navigation.print_edition')} ${t('global.sura')} ${route.params.sura} ${t(
        'global.verse',
      )} ${route.params.verse}`,
    );
    const canonicalurl = computed(
      () => `https://corpuscoranicum.de/${route.params.lang}/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/print`,
    );
    const alternate_de = computed(
      () => `https://corpuscoranicum.de/de/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/print`,
    );
    const alternate_en = computed(
      () => `https://corpuscoranicum.de/en/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/print`,
    );
    const alternate_fr = computed(
      () => `https://corpuscoranicum.de/fr/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/print`,
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

    const selectedWord: Ref<number | undefined> = ref(undefined);
    webWatcher(route, 'print-edition', printWeb);

    getPrintData(routeParamToString(route.params.lang), +route.params.sura, +route.params.verse);
    getCairoPages();

    watch([() => route.params.lang, () => route.params.sura, () => route.params.verse], () => {
      if (route.name === 'VersePrint') {
        getPrintData(
          routeParamToString(route.params.lang),
          +route.params.sura,
          +route.params.verse,
        );
        selectedWord.value = undefined;
      }
    });

    return {
      printWeb,
      printData,
      selectedWord,
      isLoaded,
    };
  },
});
</script>
