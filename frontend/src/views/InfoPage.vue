<template>
  <SectionHeader v-if="site" :title="$t(site.title)">
    <PrimaryButton
      v-if="$route.name === 'VariantReadingsOverview'"
      class="text-black w-72 mb-3 mt-5"
    >
      <router-link
        :to="{ name: 'VerseVariants', params: { sura: 1, verse: 1 } }"
        class="grid place-content-center text-black h-full w-full"
      >
        {{ $t('variants.by_verse') }}
      </router-link>
    </PrimaryButton>
  </SectionHeader>
  <template v-if="isLoaded(info)">
    <InfoItem v-for="(item, index) in info.payload" :key="index" :item="item" /> </template
  >
</template>
<script lang="ts">
import { computed, defineComponent, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { get } from '@/api/base';
import { toInfoUrl, info } from '@/api/info';
import routeParamToString from '@/router/param_as_string';
import InfoItem from '@/components/info/InfoItem.vue';
import SectionHeader from '@/components/global/SectionHeader.vue';
import PrimaryButton from '@/components/global/PrimaryButton.vue';
import { isLoaded, state } from '@/interfaces/RemoteData';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';

export default defineComponent({
  components: {
    InfoItem,
    SectionHeader,
    PrimaryButton,
  },
  setup() {
    const route = useRoute();
    const router = useRouter();
    const cleanRoute = computed(() => router.resolve({ name: route.name ?? undefined }));
    const cleanPath = computed(() => cleanRoute.value.path);
    const slug = computed(() => cleanPath.value.replace(cleanPath.value.substring(0, cleanPath.value.lastIndexOf('/') + 1), ''));
    const sites = [
      {
        route: 'PrintEditionOverview',
        title: 'print_edition.overview',
        content: 'print',
      },
      {
        route: 'VariantReadingsOverview',
        title: 'variants.overview',
        content: 'reading-variants-overview',
      },
      {
        route: 'ConcordanceOverview',
        title: 'navigation.concordance',
        content: 'concordance-overview',
      },
      {
        route: 'AboutTheProject',
        title: 'navigation.about',
        content: 'about-the-project',
      },
      {
        route: 'Tools',
        title: 'navigation.tools',
        content: 'tools',
      },
      {
        route: 'Sources',
        title: 'navigation.materials',
        content: 'sources',
      },
      {
        route: 'Research',
        title: 'navigation.research',
        content: 'research',
      },
      {
        route: 'Contact',
        title: 'navigation.contact',
        content: 'contact',
      },
      {
        route: 'FAQ',
        title: 'navigation.faq',
        content: 'faq',
      },
      {
        route: 'Impressum',
        title: 'navigation.impressum',
        content: 'impressum',
      },
      {
        route: 'DataProtection',
        title: 'navigation.privacy_policy',
        content: 'data-protection',
      },
    ];
    const site = computed(() => sites.find((s) => route.name === s.route));
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const title = computed(() => {
      if (site.value?.title) {
        return t(site.value.title);
      }
      return '';
    });
    const description = computed(() => `${t('navigation.about')}`);
    const canonical = computed(
      () => `https://corpuscoranicum.de/${route.params.lang}/about/${slug.value}`,
    );
    const alternate_de = computed(() => `https://corpuscoranicum.de/de/about/${slug.value}`);
    const alternate_en = computed(() => `https://corpuscoranicum.de/en/about/${slug.value}`);
    const alternate_fr = computed(() => `https://corpuscoranicum.de/fr/about/${slug.value}`);
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

    if (site.value) {
      get(toInfoUrl(site.value.content, routeParamToString(route.params.lang)), info);
    } else {
      info.value = { state: state.NotAsked };
    }

    watch([() => route.params, () => route.name], () => {
      if (site.value) {
        get(toInfoUrl(site.value.content, routeParamToString(route.params.lang)), info);
      } else {
        info.value = { state: state.NotAsked };
      }
    });
    return {
      info,
      isLoaded,
      site,
    };
  },
});
</script>
