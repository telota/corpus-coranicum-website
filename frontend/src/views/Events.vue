<template>
  <SectionHeader :title="$t(titleString)" />
  <template v-if="isLoaded(events)">
    <ArticleContainer v-for="e in events.payload" :key="e.title" class="showLinks my-3">
      <h2 class="pb-3">{{ e.title }}</h2>
      <p class="py-2">{{ `${$t('global.location')}: ${e.location}` }}</p>
      <p class="py-2">
        {{ `${$t('global.date')}: ${printDate(e.start)}` }}
      </p>
      <p class="py-2" v-html="e.description" />
    </ArticleContainer>
  </template>
</template>
<script lang="ts">
import { defineComponent, computed, ref, watch } from 'vue';
import { getEvents, events, getCollegium } from '@/api/academic_event';
import SectionHeader from '@/components/global/SectionHeader.vue';
import { isLoaded } from '@/interfaces/RemoteData';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import { useRoute, useRouter } from 'vue-router';
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
    const router = useRouter();
    const cleanRoute = computed(() => router.resolve({ name: route.name ?? undefined }));
    const cleanPath = computed(() => cleanRoute.value.path);
    const slug = computed(() => cleanPath.value.replace(
      cleanPath.value.substring(0, cleanPath.value.lastIndexOf('/') + 1),
      '',
    ));
    const title = computed(() => {
      if (route.name === 'Collegium') {
        return `${t('navigation.collegium_coranicum')}`;
      }
      if (route.name === 'Events') {
        return `${t('navigation.events')}`;
      }
      return '';
    });
    const description = computed(() => {
      if (route.name === 'Collegium') {
        return `${t('navigation.collegium_coranicum')}`;
      }
      if (route.name === 'Events') {
        return `${t('navigation.events')}`;
      }
      return '';
    });
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
    const titleString = ref<string>('');

    function printDate(isoString: string): string {
      const year = isoString.substring(0, 4);
      const month = isoString.substring(5, 7);
      const day = isoString.substring(8, 10);
      const hour = isoString.substring(11, 13);
      const minute = isoString.substring(14, 16);

      const date = new Date(+year, +month - 1, +day, +hour, +minute, 0);

      return date.toLocaleTimeString('de', {
        year: 'numeric',
        month: 'numeric',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
      });
    }

    function setData() {
      if (route.name === 'Events') {
        getEvents();
        titleString.value = 'navigation.events';
      }
      if (route.name === 'Collegium') {
        getCollegium();
        titleString.value = 'navigation.collegium_coranicum';
      }
    }

    setData();
    watch(
      () => route.name,
      () => {
        setData();
      },
    );

    return {
      events,
      isLoaded,
      titleString,
      printDate,
    };
  },
});
</script>
