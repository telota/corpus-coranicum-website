<template>
    <SectionHeader :infoText="manuscriptWeb.payload?.infotext">
  <template v-slot:title>
    <span v-html="$t('navigation.manuscripts')"></span>
  </template>
  <template v-slot:subtitle>
  <span v-html="`${$t('global.sura')} ${$route.params.sura} ${$t('global.verse')}
  ${$route.params.verse}`"></span>
</template>
</SectionHeader>
<VerseBar :overviewText="$t('navigation.link_overview_manuscripts')"
:middleLink="{ name: 'ManuscriptsOverview' }" />
  <div v-if="isLoaded(manuscriptVerseResults)">
    <h3 class="text-center py-5">
      {{
        $t('manuscripts.result_count', {
          count: manuscriptVerseResults.payload.length,
          sura: $route.params.sura,
          verse: $route.params.verse,
        })
      }}
    </h3>
    <ManuscriptSelect
      :sura="+$route.params.sura"
      :verse="+$route.params.verse"
      :selected="0"
      :justNavigation="true"
    />
    <div class="flex flex-wrap">
      <div
        v-for="r in manuscriptVerseResults.payload"
        :key="r.manuscript_id"
        class="w-full md:w-1/2 xl:w-1/3 my-5 p-2"
      >
        <div class="bg-white shadow">
          <router-link
            :to="{
              name: 'ManuscriptPage',
              params: {
                manuscript: r.manuscript_id,
                page: r.pages[0].folio + r.pages[0].side,
              },
              query: {
                sura: $route.params.sura,
                verse: $route.params.verse,
              },
            }"
          >
            <div class="p-3">
              <p class="md:h-20">
                <b>{{ r.title }}</b>
              </p>
              <p class="md:h-20">{{ r.archive.name }}</p>
            </div>
            <div
              v-if="typeof r.pages[0].images === 'string' || r.pages[0].images.length === 0"
              class="h-96 text-center flex flex-col justify-center px-2"
            >
              <h3 v-if="r.pages[0].images.length === 0">{{ $t('global.no_image_available') }}</h3>
              <h3 v-else>{{ $t('global.image_not_allowed') }}</h3>
            </div>
            <!-- Technically one should look through all the pages for images. -->
            <!-- This is a sloppy solution for this. -->
            <ImageHolder
              v-else
              class="h-96 text-center"
              :imageUrl="r.pages[0].images[0].image_url"
              :imageDescription="r.pages[0].images[0].image_source"
              :imageCaption="r.pages[0].images[0].image_source"
            />
            <p class="mt-6 text-center">
              {{ listPages(r.pages) }}
            </p>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent, computed, watch } from 'vue';
import { useRoute } from 'vue-router';
import SectionHeader from '@/components/global/SectionHeader.vue';
import { routeParamsToVerse } from '@/router/route_to_verse';
import { isLoaded } from '@/interfaces/RemoteData';
import { getManuscriptVerseresults, manuscriptVerseResults } from '@/api/manuscripts';
import { webWatcher, manuscriptWeb } from '@/api/web';
import VerseBar from '@/components/verse_navigation/VerseBackAndForth.vue';
import ImageHolder from '@/components/global/ImageHolder.vue';
import { ManuscriptPageResult } from '@/interfaces/ManuscriptPageResult';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';
import ManuscriptSelect from '@/components/manuscripts/ManuscriptSelect.vue';

export default defineComponent({
  components: {
    SectionHeader,
    VerseBar,
    ImageHolder,
    ManuscriptSelect,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();

    const title = computed(
      () => `${t('navigation.manuscripts')} ${t('global.sura')} ${route.params.sura} ${t(
        'global.verse',
      )} ${route.params.verse}`,
    );
    const description = computed(
      () => `${t('navigation.manuscripts')} ${t('global.sura')} ${route.params.sura} ${t(
        'global.verse',
      )} ${route.params.verse}`,
    );
    const canonicalurl = computed(
      () => `https://corpuscoranicum.de/${route.params.lang}/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/manuscripts`,
    );
    const alternate_de = computed(
      () => `https://corpuscoranicum.de/de/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/manuscripts`,
    );
    const alternate_en = computed(
      () => `https://corpuscoranicum.de/en/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/manuscripts`,
    );
    const alternate_fr = computed(
      () => `https://corpuscoranicum.de/fr/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/manuscripts`,
    );
    const meta = computed(() => ({
      title: title.value,
      description: description.value,
      link: [
        {
          rel: 'canonical',
          href: canonicalurl.value,
        },
        {
          rel: 'alternate',
          hreflang: 'de',
          href: alternate_de.value,
        },
        {
          rel: 'alternate',
          hreflang: 'en',
          href: alternate_en.value,
        },
        {
          rel: 'alternate',
          hreflang: 'fr',
          href: alternate_fr.value,
        },
        {
          rel: 'alternate',
          hreflang: 'x-default',
          href: alternate_de.value,
        },
      ],
      htmlAttrs: { lang: route.params.lang },
    }));
    useMeta(meta);
    webWatcher(route, 'manuscripts', manuscriptWeb);
    getManuscriptVerseresults(routeParamsToVerse(route.params));

    watch([() => route.params], () => {
      if (route.name === 'VerseManuscriptResults') {
        getManuscriptVerseresults(routeParamsToVerse(route.params));
      }
    });

    function listPages(pages: ManuscriptPageResult[]) {
      return `${t('manuscripts.pages')}: ${pages.map((p) => p.folio + p.side).join(', ')}.`;
    }

    return {
      manuscriptVerseResults,
      manuscriptWeb,
      isLoaded,
      listPages,
    };
  },
});
</script>
