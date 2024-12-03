<template>
  <SectionHeader :infoText="variantsWeb.payload?.infotext">
  <template v-slot:title>
    <span v-html="$t('navigation.variant_readings') + ' <small>' + $t('global.sura') + ' '
+ $route.params.sura  + ' ' + $t('global.verse') + ' ' +
$route.params.verse + '</small>'"></span>
  </template>
</SectionHeader>
<VerseBar :overviewText="$t('navigation.link_overview_variants')"
:middleLink="{ name: 'VariantReadingsOverview' }" />
  <template v-if="isLoaded(variantResults) && isLoaded(canonical)">
    <i18n-t
      keypath="variants.explanation"
      tag="p"
      for="variants.overview_link"
      class="text-center showLinks pt-6"
    >
      <router-link :to="{ name: 'VariantReadingsOverview' }">{{
        $t('variants.overview_link')
      }}</router-link>
    </i18n-t>
    <div class="py-6 text-center">
      <div class="inline-block max-w-full text-right">
        <div class="py-2">
          <label for="filter">{{ $t('variants.filter_table') + ':' }}</label>
          <input
            type="text"
            id="filter"
            placeholder="Search terms..."
            class="border mx-2"
            v-model="search"
          />
        </div>
        <div class="text-center max-w-full inline-block overflow-x-auto bg-white border-2">
          <VariantsTable
            :variants="variantResults.payload"
            :canonical="canonical.payload"
            :searchTerm="searchTerm"
            class="mx-auto"
          />
        </div>
      </div>
      <p class="py-3">
        {{ $t('variants.click_instruction') }}
      </p>
    </div>
    <VerseText :verse="variantResults.payload.reference" />
    <div v-if="variantResults.payload.commentary">
      <div class="max-w-screen-md mx-auto bg-white py-6 p-3">
        <h2 class="py-3 text-center">{{ $t('variants.verse_commentary') }}</h2>
        <p v-html="variantResults.payload.commentary" />
      </div>
    </div>
    <VariantsContributors
      v-if="isLoaded(variantResults) && variantResults.payload.citations.length > 0"
      :contributions="variantResults.payload.citations"
    />
    <HowToQuote v-if="isLoaded(variantsWeb)" :citation="variantsWeb.payload.how_to_cite" />
  </template>
</template>
<script lang="ts">
import { computed, defineComponent, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { routeParamsToVerse } from '@/router/route_to_verse';
import SectionHeader from '@/components/global/SectionHeader.vue';
import VerseBar from '@/components/verse_navigation/VerseBackAndForth.vue';
import VerseText from '@/components/variants/VerseText.vue';
import VariantsContributors from '@/components/variants/VariantsContributors.vue';
import VariantsTable from '@/components/variants/VariantsTable.vue';
import HowToQuote from '@/components/global/HowToQuote.vue';
import { isLoaded } from '@/interfaces/RemoteData';
import { getVariants, canonical, getCanonical, variantResults, selectedWord } from '@/api/variants';
import { webWatcher, variantsWeb } from '@/api/web';
import { makeSearchTerm } from '@/components/variants/letterMultiplier';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';

export default defineComponent({
  components: {
    SectionHeader,
    VerseBar,
    VerseText,
    VariantsTable,
    VariantsContributors,
    HowToQuote,
  },
  setup() {
    const {
      t,
    } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();
    const title = computed(
      () => `${t('navigation.variant_readings')} ${t('global.sura')} ${route.params.sura} ${t(
        'global.verse',
      )} ${route.params.verse}`,
    );
    const description = computed(
      () => `${t('navigation.variant_readings')} ${t('global.sura')} ${route.params.sura} ${t(
        'global.verse',
      )} ${route.params.verse}`,
    );
    const canonicalurl = computed(
      () => `https://corpuscoranicum.de/${route.params.lang}/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/variants`,
    );
    const alternate_de = computed(
      () => `https://corpuscoranicum.de/de/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/variants`,
    );
    const alternate_en = computed(
      () => `https://corpuscoranicum.de/en/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/variants`,
    );
    const alternate_fr = computed(
      () => `https://corpuscoranicum.de/fr/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/variants`,
    );
    const meta = computed(() => ({
      title: title.value,
      description: description.value,
      link: [
        {
          rel: 'canonical', href: canonicalurl.value,
        },
        {
          rel: 'alternate', hreflang: 'de', href: alternate_de.value,
        },
        {
          rel: 'alternate', hreflang: 'en', href: alternate_en.value,
        },
        {
          rel: 'alternate', hreflang: 'fr', href: alternate_fr.value,
        },
        {
          rel: 'alternate', hreflang: 'x-default', href: alternate_de.value,
        },
      ],
      htmlAttrs: {
        lang: route.params.lang,
      },
    }));
    useMeta(meta);
    webWatcher(route, 'variants', variantsWeb);

    getVariants(routeParamsToVerse(route.params));
    getCanonical();

    const search = ref<string>('');

    watch([() => route.params], () => {
      if (route.name === 'VerseVariants') {
        getVariants(routeParamsToVerse(route.params));
      }
    });

    watch(selectedWord, () => {
      console.log(selectedWord.value);
      if (selectedWord.value !== undefined) {
        console.log('running selected word', selectedWord.value);
        const el = document.getElementById(`word-column-${+selectedWord.value + 1}`);
        if (el) {
          console.log(el);
          el.scrollIntoView({
            behavior: 'smooth',
            inline: 'end',
            block: 'nearest',
          });
        }
      }
    });

    const searchTerm = computed(() => makeSearchTerm(search.value));

    return {
      isLoaded,
      variantResults,
      variantsWeb,
      canonical,
      search,
      searchTerm,
    };
  },
});
</script>
