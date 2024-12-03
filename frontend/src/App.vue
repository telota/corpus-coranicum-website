<template>
  <metainfo>
    <template v-slot:title="{ content }">{{
      content ? `${content} | Corpus Coranicum` : `Corpus Coranicum`
    }}</template>
    <template v-slot:desription="{ content }">{{
      content ? `${content} | Corpus Coranicum` : `Corpus Coranicum`
    }}</template>
  </metainfo>
  <div class="flex flex-col min-h-screen w-full overflow-x-hidden">
    <Header />
    <VerseNavBar v-if="$route.matched.findIndex((r) => r.name === 'VerseNavigator') >= 0" />
    <div class="flex-grow bg-grey-light flex">
      <div class="container mx-auto">
        <router-view class="flex-grow" />
      </div>
    </div>
    <Footer />
  </div>
  <ErrorModal v-if="errors.length > 0" @close="clearErrors" />
</template>
<script lang="ts">
import { computed, defineComponent, watch } from 'vue';
import { useMeta } from 'vue-meta';
import Header from '@/components/global/Header.vue';
import VerseNavBar from '@/components/verse_navigation/VerseNavBar.vue';
import Footer from '@/components/global/Footer.vue';
import ErrorModal from '@/components/global/ErrorModal.vue';
import { useRoute } from 'vue-router';
import { clearErrors, errors } from './api/base';

export default defineComponent({
  components: {
    Header,
    Footer,
    VerseNavBar,
    ErrorModal,
  },
  setup() {
    const route = useRoute();
    const meta = computed(() => ({
      htmlAttrs: { lang: route.params.lang ?? '' },
      description: 'Corpus Coranicum',
      link: [
        {
          rel: 'canonical',
          href: `https://corpuscoranicum.de/${route.params.lang}`,
        },
        {
          rel: 'alternate',
          hreflang: 'de',
          href: 'https://corpuscoranicum.de/de',
        },
        {
          rel: 'alternate',
          hreflang: 'en',
          href: 'https://corpuscoranicum.de/en',
        },
        {
          rel: 'alternate',
          hreflang: 'fr',
          href: 'https://corpuscoranicum.de/fr',
        },
        {
          rel: 'alternate',
          hreflang: 'x-default',
          href: 'https://corpuscoranicum.de/de',
        },
      ],
    }));
    useMeta(meta);

    function checkNotFound() {
      const robotsTag = document.querySelector("meta[name='robots']");
      if (robotsTag) {
        robotsTag.remove();
      }
      const metaRobots = document.createElement('meta');
      metaRobots.name = 'robots';
      if (route.name === 'NotFound' || route.name === 'LanguageNotFound') {
        metaRobots.content = 'noindex, nofollow';
      } else {
        metaRobots.content = 'index, follow';
      }
      document.head.appendChild(metaRobots);
    }
    checkNotFound();

    watch(route, () => {
      checkNotFound();
    });

    return {
      errors,
      clearErrors,
    };
  },
});
</script>
