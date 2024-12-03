<template>
  <SectionHeader :title="$t('commentary.overview')" />
  <template v-if="isLoaded(info)">
    <InfoItem v-for="(item, index) in info.payload" :key="index" :item="item" />
  </template>
  <ArticleContainer class="my-3">
    <ListOfSuras />
  </ArticleContainer>
</template>
<script lang="ts">
import { defineComponent, computed } from 'vue';
import { useRoute } from 'vue-router';
import routeParamToString from '@/router/param_as_string';
import { getAndGetOnNewLanguage } from '@/api/base';
import { info, toInfoUrl } from '@/api/info';
import { isLoaded } from '@/interfaces/RemoteData';
import InfoItem from '@/components/info/InfoItem.vue';
import SectionHeader from '@/components/global/SectionHeader.vue';
import ListOfSuras from '@/components/commentary/ListOfSuras.vue';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';

export default defineComponent({
  components: {
    InfoItem,
    SectionHeader,
    ListOfSuras,
    ArticleContainer,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();
    const title = computed(
      () => `${t('navigation.commentary')} ${t('global.overview')}`,
    );
    const description = computed(
      () => `${t('navigation.commentary')} ${t('global.overview')}`,
    );
    const canonical = computed(
      () => `https://corpuscoranicum.de/${route.params.lang}/commentary`,
    );
    const alternate_de = computed(
      () => 'https://corpuscoranicum.de/de/commentary',
    );
    const alternate_en = computed(
      () => 'https://corpuscoranicum.de/en/commentary',
    );
    const alternate_fr = computed(
      () => 'https://corpuscoranicum.de/fr/commentary',
    );
    const meta = computed(() => ({
      title: title.value,
      description: description.value,
      link: [
        { rel: 'canonical', href: canonical.value },
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
    getAndGetOnNewLanguage(
      toInfoUrl('commentary-overview', routeParamToString(route.params.lang)),
      info,
      route,
    );
    const publicPath = process.env.BASE_URL;
    return {
      info,
      isLoaded,
      publicPath,
    };
  },
});
</script>
