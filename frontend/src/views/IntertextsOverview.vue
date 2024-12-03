<template>
  <SectionHeader :title="$t('intertext.overview')" />
  <RemoteContent :data="allIntertexts">
    <TableOfContents :listing="tableOfContents" />
    <ArticleContainer v-if="isLoaded(intertextWeb)" :id="introId" class="my-6 showLinks">
      <h3 class="text-center pb-2">
        {{ $t('global.introduction') }}
      </h3>
      <p>
        {{ intertextWeb.payload.introduction_general }}
      </p>
      <BackToTop />
    </ArticleContainer>
    <h2 class="text-center pt-3" :id="categoriesId">
      {{ $t('intertext.categories') }}
    </h2>
    <CategoryListing :byCategory="byCategory" />
    <h2 class="text-center pt-3" :id="languagesId">
      {{ $t('intertext.languages') }}
    </h2>
    <ArticleContainer
      v-for="([key, intertexts], index) in byLanguage.entries()"
      :key="key"
      class="showLinks my-3"
      :id="`language_${index + 1}`"
    >
      <h3 class="text-center">{{ key }}</h3>
      <IntertextListing v-for="i in intertexts" :key="i.id" :intertext="i" />
      <BackToTop />
    </ArticleContainer>
  </RemoteContent>
</template>
<script lang="ts">
import { computed, defineComponent } from 'vue';
import { useRoute } from 'vue-router';
import SectionHeader from '@/components/global/SectionHeader.vue';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import { intertextWeb, webWatcher } from '@/api/web';
import { isLoaded } from '@/interfaces/RemoteData';
import { allIntertexts, getAllIntertexts } from '@/api/intertext';
import { groupBy, IntertextShort } from '@/interfaces/IntertextShort';
import CategoryListing from '@/components/intertext/CategoryListing.vue';
import TableOfContents from '@/components/global/TableOfContents.vue';
import IntertextListing from '@/components/intertext/IntertextListing.vue';
import BackToTop from '@/components/intertext/BackToTop.vue';
import RemoteContent from '@/components/global/RemoteContent.vue';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';

export default defineComponent({
  components: {
    SectionHeader,
    RemoteContent,
    TableOfContents,
    ArticleContainer,
    BackToTop,
    CategoryListing,
    IntertextListing,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();
    const title = computed(
      () => `${t('navigation.intertexts')} ${t('global.overview')}`,
    );
    const description = computed(
      () => `${t('navigation.intertexts')} ${t('global.overview')}`,
    );
    const canonical = computed(
      () => `https://corpuscoranicum.de/${route.params.lang}/intertexts`,
    );
    const alternate_de = computed(
      () => 'https://corpuscoranicum.de/de/intertexts',
    );
    const alternate_en = computed(
      () => 'https://corpuscoranicum.de/en/intertexts',
    );
    const alternate_fr = computed(
      () => 'https://corpuscoranicum.de/fr/intertexts',
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
    webWatcher(route, 'intertexts', intertextWeb);
    getAllIntertexts();

    const byLanguage = computed(() => {
      if (isLoaded(allIntertexts.value)) {
        return groupBy(allIntertexts.value.payload, (i) => i.language);
      }

      return new Map();
    });

    const byCategory = computed(() => {
      const getCategory = (i: IntertextShort) => {
        if (i.supercategory) {
          return i.supercategory;
        }
        return i.category;
      };

      if (isLoaded(allIntertexts.value)) {
        return groupBy(allIntertexts.value.payload, getCategory);
      }

      return new Map();
    });

    const introId = 'introduction';
    const categoriesId = 'categories';
    const languagesId = 'languages';
    const tableOfContents = computed(() => [
      {
        link: introId,
        text: t('global.introduction'),
      },
      {
        link: categoriesId,
        text: t('intertext.categories'),
        children: Array.from(byCategory.value.keys()).map((cat, index) => ({
          link: `category_${index + 1}`,
          text: cat,
        })),
      },
      {
        link: languagesId,
        text: t('intertext.languages'),
        children: Array.from(byLanguage.value.keys()).map((lang, index) => ({
          link: `language_${index + 1}`,
          text: lang,
        })),
      },
    ]);
    return {
      intertextWeb,
      isLoaded,
      allIntertexts,
      byLanguage,
      byCategory,
      tableOfContents,
      introId,
      categoriesId,
      languagesId,
    };
  },
});
</script>
