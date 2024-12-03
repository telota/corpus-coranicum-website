<template>
  <SectionHeader :title="$t('navigation.contributors')" />
  <ArticleContainer v-if="isLoaded(contributors)" class="mb-6">
    <div v-for="group in contributors.payload" :key="group.role" class="py-3 showLinks">
      <h3 class="pb-2">{{ group.role }}</h3>
      <p v-for="p in group.people" :key="p" v-html="p" class="pl-2" />
    </div>
  </ArticleContainer>
</template>
<script lang="ts">
import { defineComponent, computed } from 'vue';
import SectionHeader from '@/components/global/SectionHeader.vue';
import { isLoaded } from '@/interfaces/RemoteData';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import { useRoute } from 'vue-router';
import { contributors, toUrl } from '@/api/contributors';
import routeParamToString from '@/router/param_as_string';
import { getAndGetOnNewLanguage } from '@/api/base';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';

export default defineComponent({
  components: {
    SectionHeader,
    ArticleContainer,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();
    const title = computed(
      () => `${t('navigation.contributors')}`,
    );
    const description = computed(
      () => `${t('navigation.contributors')}`,
    );
    const canonical = computed(
      () => `https://corpuscoranicum.de/${route.params.lang}/about/team`,
    );
    const alternate_de = computed(
      () => 'https://corpuscoranicum.de/de/about/team',
    );
    const alternate_en = computed(
      () => 'https://corpuscoranicum.de/en/about/team',
    );
    const alternate_fr = computed(
      () => 'https://corpuscoranicum.de/fr/about/team',
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

    getAndGetOnNewLanguage(toUrl(routeParamToString(route.params.lang)), contributors, route);

    return {
      contributors,
      isLoaded,
    };
  },
});
</script>
