<template>
  <div class='py-6' id='manuscript_page'>
    <PageNav />
    <div v-if='isLoaded(pageDetail)'>
      <MaybePageImages
        v-if='!pageDetail.payload.transliteration'
        :images='pageDetail.payload.images'
      />
      <TwoItems v-else>
        <template v-slot:first>
          <MaybePageImages :images='pageDetail.payload.images' />
        </template>
        <template v-slot:second>
          <Card
            v-if='pageDetail.payload.transliteration'
            :title="$t('manuscripts.transliteration')"
            :informationText='manuscriptWeb.payload?.transliteration_info'
          >
            <table
              class='transliteration table-auto arabic pt-3 w-full'
              v-html='pageDetail.payload.transliteration'
            />
            <TransliterationKey class='mx-2 pt-8 pb-2' />
          </Card>
        </template>
      </TwoItems>
      <ReferenceVerses :verses='pageDetail.payload.verses' class='pt-6' />
    </div>
    <div v-else-if='isLoading(pageDetail)' class='relative h-96'>
      <LoadingSpinner class='absolute top-1/2 left-1/2 z-10' />
    </div>
  </div>
</template>
<script lang='ts'>
import { defineComponent, computed, watch } from 'vue';
import { useRoute } from 'vue-router';
import routeParamToString from '@/router/param_as_string';
import { isLoaded, isLoading } from '@/interfaces/RemoteData';
import { getPageDetail, pageDetail, manuscriptDetail } from '@/api/manuscripts';
import { manuscriptWeb } from '@/api/web';
import PageNav from '@/components/manuscripts/PageNav.vue';
import LoadingSpinner from '@/components/global/LoadingSpinner.vue';
import TwoItems from '@/components/global/TwoItems.vue';
import Card from '@/components/global/Card.vue';
import ReferenceVerses from '@/components/manuscripts/ReferenceVerses.vue';
import MaybePageImages from '@/components/manuscripts/MaybePageImages.vue';
import TransliterationKey from '@/components/manuscripts/TransliterationKey.vue';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';
import { manuscriptTitle } from '@/interfaces/ManuscriptDetail';

export default defineComponent({
  components: {
    PageNav,
    LoadingSpinner,
    TwoItems,
    MaybePageImages,
    Card,
    ReferenceVerses,
    TransliterationKey,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();
    const pagetitle = computed(() => {
      if (isLoaded(manuscriptDetail.value)) {
        return manuscriptTitle(manuscriptDetail.value.payload);
      }
      return '';
    });

    const title = computed(() => {
      const begin = `${pagetitle.value} > ${t('navigation.manuscripts')} `;

      if (route.params.verse) {
        const verse = `${t('global.sura')} ${route.params.sura} ${t('global.verse')} ${route.params.verse}`;
        return begin.concat(verse);
      }
      return begin;
    });

    const description = computed(() => {
      if (route.params.verse) {
        return `${pagetitle.value} > ${t('navigation.manuscripts')} ${t('global.sura')} ${
          route.params.sura
        } ${t('global.verse')} ${route.params.verse}`;
      }
      return `${pagetitle.value} > ${t('navigation.manuscripts')}`;
    });

    const canonicalurl = computed(
      () => `https://corpuscoranicum.de/${route.params.lang}/manuscripts/${route.params.manuscript}/page/${route.params.page}`,
    );
    const alternate_de = computed(
      () => `https://corpuscoranicum.de/de/manuscripts/${route.params.manuscript}/page/${route.params.page}`,
    );
    const alternate_en = computed(
      () => `https://corpuscoranicum.de/en/manuscripts/${route.params.manuscript}/page/${route.params.page}`,
    );
    const alternate_fr = computed(
      () => `https://corpuscoranicum.de/fr/manuscripts/${route.params.manuscript}/page/${route.params.page}`,
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
    getPageDetail(
      routeParamToString(route.params.lang),
      +routeParamToString(route.params.manuscript),
      routeParamToString(route.params.page),
    );

    watch([() => route.params], () => {
      if (route.name === 'ManuscriptPage') {
        getPageDetail(
          routeParamToString(route.params.lang),
          +routeParamToString(route.params.manuscript),
          routeParamToString(route.params.page),
        );
      }
    });

    return {
      pageDetail,
      isLoaded,
      isLoading,
      manuscriptWeb,
    };
  },
});
</script>
