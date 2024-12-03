<template>
  <SectionHeader :infoText="commentaryWeb.payload?.infotext">
  <template v-slot:title>
    <span v-html="$t('navigation.commentary') + ' <small>' + $t('global.sura') + ' '
+ $route.params.sura + '</small>'"></span>
  </template>
</SectionHeader>
  <SuraNavigation :overviewText="$t('commentary.to_overview')"
  :middleLink="{ name: 'CommentaryOverview' }"  />
  <Popper />
  <template v-if="isLoaded(commentary)">
    <ArticleContainer v-if="isLoaded(commentary)" class="my-3">
      <h2 v-html="commentary.payload.title" class="py-3" />
      <h3 class="py-3">{{ commentary.payload.author }}</h3>
      <i18n-t
        v-if="commentaryEra(+$route.params.sura)"
        keypath="commentary.classification"
        tag="p"
        class="showLinks"
      >
        <router-link
          :to="{
            name: 'CommentaryIntroduction',
            params: {
              intro: commentaryEra(+$route.params.sura),
            },
          }"
        >
          {{ $t(`commentary.intro_${commentaryEra(+$route.params.sura)}`) }}
        </router-link>
      </i18n-t>
    </ArticleContainer>
    <TableOfContents
      v-if="isLoaded(commentary)"
      :listing="toTableOfContents(commentary.payload)"
      class="my-6"
    />
    <CommentaryArticle v-if="isLoaded(commentary)" :commentary="commentary.payload" />
    <HowToQuote :citation="commentary.payload.how_to_cite" />
  </template>
  <NotFound v-else-if="notFound(commentary)" class="pt-12" />
</template>
<script lang="ts">
import { defineComponent, computed, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import { initializePopper } from '@/components/commentary/popper';
import SectionHeader from '@/components/global/SectionHeader.vue';
import { getCommentary, commentary } from '@/api/commentary';
import { isLoaded, notFound } from '@/interfaces/RemoteData';
import { webWatcher, commentaryWeb } from '@/api/web';
import SuraNavigation from '@/components/commentary/SuraNavigation.vue';
import Popper from '@/components/commentary/Popper.vue';
import NotFound from '@/components/commentary/NotFound.vue';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import CommentaryArticle from '@/components/commentary/CommentaryArticle.vue';
import TableOfContents from '@/components/global/TableOfContents.vue';
import { toTableOfContents } from '@/interfaces/Commentary';
import { commentaryEra } from '@/components/commentary/suraClassification';
import HowToQuote from '@/components/global/HowToQuote.vue';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';

export default defineComponent({
  components: {
    ArticleContainer,
    SectionHeader,
    CommentaryArticle,
    NotFound,
    Popper,
    SuraNavigation,
    TableOfContents,
    HowToQuote,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();
    const pagetitle = computed(() => {
      if (isLoaded(commentary.value)) {
        return commentary.value.payload.title;
      }
      return '';
    });
    const title = computed(
      () => `${pagetitle.value} > ${t('navigation.commentary')} ${t('global.sura')} ${route.params.sura} ${t(
        'global.verse',
      )} ${route.params.verse}`,
    );
    const description = computed(
      () => `${pagetitle.value} > ${t('navigation.commentary')} ${t('global.sura')} ${route.params.sura} ${t(
        'global.verse',
      )} ${route.params.verse}`,
    );
    const canonical = computed(
      () => `https://corpuscoranicum.de/${route.params.lang}/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/commentary/`,
    );
    const alternate_de = computed(
      () => `https://corpuscoranicum.de/de/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/commentary/`,
    );
    const alternate_en = computed(
      () => `https://corpuscoranicum.de/en/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/commentary/`,
    );
    const alternate_fr = computed(
      () => `https://corpuscoranicum.de/fr/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/commentary/`,
    );
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
    webWatcher(route, 'commentary', commentaryWeb);
    getCommentary(+route.params.sura);

    watch(
      () => route.params.sura,
      () => {
        if (route.name === 'VerseCommentary') {
          getCommentary(+route.params.sura);
        }
      },
    );

    onMounted(() => {
      initializePopper();
    });

    return {
      isLoaded,
      notFound,
      commentary,
      commentaryWeb,
      toTableOfContents,
      commentaryEra,
    };
  },
});
</script>
