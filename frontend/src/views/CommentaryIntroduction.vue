<template>
  <SectionHeader :title="$t('commentary.introduction')" />
  <div class="flex justify-center items-center w-[100%]">
  <PrimaryButton class="text-black w-72">
    <router-link
      :to="{ name: 'CommentaryOverview' }"
      class="grid place-content-center text-black h-full w-full"
    >
      {{ $t('commentary.overview') }}
    </router-link>
  </PrimaryButton>
  </div>
  <Popper />
  <RemoteContent :data="intro">
    <template v-if="isLoaded(intro)">
      <ArticleContainer class="my-3">
        <h2>{{ intro.payload.title }}</h2>
        <h4>{{ intro.payload.author }}</h4>
        <h4>{{ intro.payload.subauthor }}</h4>
      </ArticleContainer>
      <TableOfContents :listing="intro.payload.table_of_contents" class="my-3" />
      <ArticleContainer
        v-for="section in intro.payload.sections"
        :key="section.title"
        class="my-3 showTable spaceHeaders spaceParagraphsSmall"
      >
        <h2 :id="section.id">{{ section.title }}</h2>
        <div v-html="section.content" class="showLinks break-words" />
      </ArticleContainer>
      <HowToQuote :citation="intro.payload.how_to_cite" />
    </template>
  </RemoteContent>
</template>
<script lang="ts">
import { defineComponent, onMounted, onUpdated } from 'vue';
import SectionHeader from '@/components/global/SectionHeader.vue';
import Popper from '@/components/commentary/Popper.vue';
import PrimaryButton from '@/components/global/PrimaryButton.vue';
import { getIntro, intro } from '@/api/commentary';
import { isLoaded } from '@/interfaces/RemoteData';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import RemoteContent from '@/components/global/RemoteContent.vue';
import TableOfContents from '@/components/global/TableOfContents.vue';
import { connectQuranRefsToPopper, initializePopper } from '@/components/commentary/popper';
import { useRoute, useRouter } from 'vue-router';
import { createLinks } from '@/components/commentary/linker';
import routeParamToString from '@/router/param_as_string';
import scrollToHash from '@/components/global/scrollToHash';
import HowToQuote from '@/components/global/HowToQuote.vue';
import { useI18n } from 'vue-i18n';

export default defineComponent({
  components: {
    RemoteContent,
    SectionHeader,
    PrimaryButton,
    Popper,
    ArticleContainer,
    TableOfContents,
    HowToQuote,
  },
  setup() {
    const router = useRouter();
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();
    // const title = computed(
    //   () => `${t('navigation.intertexts')} ${t('global.overview')}`,
    // );
    // const description = computed(
    //   () => `ssss${t('navigation.intertexts')} ${t('global.overview')}`,
    // );
    // const canonical = computed(
    //   () => `https://corpuscoranicum.de/${route.params.lang}/commentary`,
    // );
    // const alternate_de = computed(
    //   () => 'https://corpuscoranicum.de/de/commentaryddd',
    // );
    // const alternate_en = computed(
    //   () => 'https://corpuscoranicum.de/en/commentary',
    // );
    // const alternate_fr = computed(
    //   () => 'https://corpuscoranicum.de/fr/commentary',
    // );
    // const meta = computed(() => ({
    //   title: title.value,
    //   description: description.value,
    //   link: [
    //     { rel: 'canonical', href: canonical.value },
    //     { rel: 'alternate', hreflang: 'de', href: alternate_de.value },
    //     { rel: 'alternate', hreflang: 'en', href: alternate_en.value },
    //     { rel: 'alternate', hreflang: 'fr', href: alternate_fr.value },
    //     { rel: 'alternate', hreflang: 'x-default', href: alternate_de.value },
    //   ],
    //   htmlAttrs: {
    //     lang: route.params.lang,
    //   },
    // }));
    // useMeta(meta);
    getIntro(routeParamToString(route.params.intro));

    function makeLinksAndPoppers() {
      createLinks(router, route);

      // Hook up Quran references to popper.
      connectQuranRefsToPopper(routeParamToString(route.params.lang));
    }

    onMounted(() => {
      initializePopper();
      scrollToHash(route);
      makeLinksAndPoppers();
    });

    onUpdated(() => {
      makeLinksAndPoppers();
    });

    return {
      intro,
      isLoaded,
    };
  },
});
</script>
