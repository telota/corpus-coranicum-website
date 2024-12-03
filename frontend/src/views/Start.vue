<template>
  <SectionHeader title="Corpus Coranicum" />
  <RemoteContent :data="info">
    <div class="flex flex-wrap showLinks justify-center">
      <div
        v-for="item in info.payload"
        :key="item.title"
        class="w-96 bg-grey-light px-2 pt-4"
      >
        <div class="py-6 px-2 w-full sm:w-96 bg-white shadow" style="height: 34rem">
          <h3 class="text-center">{{ item.title }}</h3>
          <p class="text-center">{{ item.subtitle }}</p>
          <a
            :href="
              item.links[0].add_language
                ? `${$i18n.locale}/${item.links[0].url}`
                : item.links[0].url
            "
          >
            <ImageHolder
              :imageUrl="publicPath + 'img/' + item.image"
              class="px-4 h-48 text-center my-4 round-image"
            />
          </a>
          <ul class="text-center">
            <li v-for="l in item.links" :key="l.url">
              <a :href="l.add_language ? `${$i18n.locale}/${l.url}` : l.url">{{ l.text }} </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <ArticleContainer class="my-6">
      <h2 class="text-center mt-6">{{ $t('navigation.in_the_press') }}</h2>
      <Press class="showLinks mx-auto my-3 max-w-screen-lg" />
    </ArticleContainer>
  </RemoteContent>
</template>
<script lang="ts">
import { defineComponent, computed } from 'vue';
import { useRoute } from 'vue-router';
import { getAndGetOnNewLanguage } from '@/api/base';
import { toInfoUrl, info } from '@/api/info';
import routeParamToString from '@/router/param_as_string';
import Press from '@/components/info/Press.vue';
import ImageHolder from '@/components/global/ImageHolder.vue';
import { isLoaded } from '@/interfaces/RemoteData';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import SectionHeader from '@/components/global/SectionHeader.vue';
import RemoteContent from '@/components/global/RemoteContent.vue';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';

export default defineComponent({
  components: {
    ImageHolder,
    Press,
    ArticleContainer,
    SectionHeader,
    RemoteContent,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();
    const title = computed(
      () => '',
    );
    const description = computed(
      () => 'Corpus Coranicum',
    );
    const canonical = computed(
      () => `https://corpuscoranicum.de/${route.params.lang}`,
    );
    const alternate_de = computed(
      () => 'https://corpuscoranicum.de/de',
    );
    const alternate_en = computed(
      () => 'https://corpuscoranicum.de/en',
    );
    const alternate_fr = computed(
      () => 'https://corpuscoranicum.de/fr',
    );
    const meta = computed(() => ({
      title: title.value,
      description: description.value,
      link: [
        {
          rel: 'canonical', href: canonical.value,
        },
        {
          rel: 'alternate', hreflang: 'de', href: alternate_de.value,
        },
        {
          rel: 'alternate', hreflang: 'en', href: alternate_en.value,
        },
        {
          rel: 'alternate', hreflang: 'fr', href: alternate_fr.value,
        },
        {
          rel: 'alternate', hreflang: 'x-default', href: alternate_de.value,
        },
      ],
      htmlAttrs: { lang: route.params.lang },
    }));
    useMeta(meta);
    getAndGetOnNewLanguage(toInfoUrl('start', routeParamToString(route.params.lang)), info, route);
    const publicPath = process.env.BASE_URL;
    return {
      info,
      isLoaded,
      publicPath,
    };
  },
});
</script>
