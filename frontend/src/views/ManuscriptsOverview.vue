<template>
  <SectionHeader :infoText="manuscriptWeb.payload?.infotext">
  <template v-slot:title>
    <span v-html="$t('manuscripts.overview')"></span>
  </template>
</SectionHeader>
  <RemoteContent :data="manuscriptWeb">
    <ArticleContainer v-if="isLoaded(manuscriptWeb)" class="my-6">
      <p>
        {{ manuscriptWeb.payload.introduction }}
      </p>
    </ArticleContainer>
  </RemoteContent>
  <h2 class="text-center">{{ $t('manuscripts.by_archive') }}</h2>
  <RemoteContent :data="archives">
    <div v-if="isLoaded(archives)" class="py-6">
      <a id="archive_{{ a.id }}" v-for="a in archives.payload" :key="a.id" />
      <ArchiveDescription v-for="a in archives.payload" :key="a.name" :archive="a" />
    </div>
  </RemoteContent>
</template>
<script lang="ts">
import { defineComponent, computed, watch } from 'vue';
import { useRoute } from 'vue-router';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import SectionHeader from '@/components/global/SectionHeader.vue';
import ArchiveDescription from '@/components/manuscripts/ArchiveDescription.vue';
import { manuscriptWeb, webWatcher } from '@/api/web';
import { isLoaded } from '@/interfaces/RemoteData';
import { archives, getArchives } from '@/api/manuscripts';
import routeParamToString from '@/router/param_as_string';
import scrollToHash from '@/components/global/scrollToHash';
import RemoteContent from '@/components/global/RemoteContent.vue';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';

export default defineComponent({
  components: {
    ArticleContainer,
    SectionHeader,
    ArchiveDescription,
    RemoteContent,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();
    const title = computed(() => `${t('navigation.manuscripts')} ${t('global.overview')}`);
    const description = computed(() => `${t('navigation.manuscripts')} ${t('global.overview')}`);
    const canonical = computed(() => `https://corpuscoranicum.de/${route.params.lang}/manuscripts`);
    const alternate_de = computed(() => 'https://corpuscoranicum.de/de/manuscripts');
    const alternate_en = computed(() => 'https://corpuscoranicum.de/en/manuscripts');
    const alternate_fr = computed(() => 'https://corpuscoranicum.de/fr/manuscripts');
    const meta = computed(() => ({
      title: title.value,
      description: description.value,
      link: [
        {
          rel: 'canonical',
          href: canonical.value,
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
    getArchives(routeParamToString(route.params.lang));
    webWatcher(route, 'manuscripts', manuscriptWeb);
    watch(
      () => route.params.lang,
      () => {
        if (route.name === 'ManuscriptsOverview') {
          getArchives(routeParamToString(route.params.lang));
        }
      },
    );
    watch(archives, () => {
      if (isLoaded(archives.value)) {
        window.setTimeout(() => {
          scrollToHash(route);
        }, 0);
      }
    });
    return {
      manuscriptWeb,
      isLoaded,
      archives,
    };
  },
});
</script>
