<template>
  <RemoteContent :data="intertextDetail">
    <div v-if="intertextDetail.payload?.passages.find(verseInRange(verse)) || showIntertextAnyway">
      <IntertextFull :intertext="intertextDetail.payload" />
    </div>
    <div v-else class="pt-10">
      <h3 class="text-center py-5">
        {{ $t('intertext.no_matching_verse', { id: $route.params.id }) }}
      </h3>
      <PrimaryButton class="text-black w-72 m-auto block" @click="showIntertextAnyway = true">
        {{ $t('intertext.show_it_anyway') }}
      </PrimaryButton>
    </div>
  </RemoteContent>
</template>
<script lang="ts">
import { defineComponent, ref, watch, computed } from 'vue';
import { useRoute } from 'vue-router';
import { routeParamsToVerse } from '@/router/route_to_verse';
import { getIntertextDetail, intertextDetail } from '@/api/intertext';
import routeParamToString from '@/router/param_as_string';
import { isLoading, isLoaded } from '@/interfaces/RemoteData';
import IntertextFull from '@/components/intertext/IntertextFull.vue';
import PrimaryButton from '@/components/global/PrimaryButton.vue';
import { Verse } from '@/interfaces/Verse';
import { verseInRange } from '@/interfaces/VerseRange';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';
import RemoteContent from '@/components/global/RemoteContent.vue';

export default defineComponent({
  components: {
    RemoteContent,
    IntertextFull,
    PrimaryButton,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const pagetitle = computed(() => {
      if (isLoaded(intertextDetail.value)) {
        return intertextDetail.value.payload.title;
      }
      return '';
    });
    const route = useRoute();
    const title = computed(
      () => `${pagetitle.value} > ${t('navigation.intertexts')} ${t('global.sura')} ${
        route.params.sura
      } ${t('global.verse')} ${route.params.verse}`,
    );
    const description = computed(
      () => `${pagetitle.value} > ${t('navigation.intertexts')} ${t('global.sura')} ${
        route.params.sura
      } ${t('global.verse')} ${route.params.verse}`,
    );
    const canonical = computed(
      () => `https://corpuscoranicum.de/${route.params.lang}/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/intertexts/${route.params.id}`,
    );
    const alternate_de = computed(
      () => `https://corpuscoranicum.de/de/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/intertexts/${route.params.id}`,
    );
    const alternate_en = computed(
      () => `https://corpuscoranicum.de/en/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/intertexts/${route.params.id}`,
    );
    const alternate_fr = computed(
      () => `https://corpuscoranicum.de/fr/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/intertexts/${route.params.id}`,
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
    const verse = ref<Verse>(routeParamsToVerse(route.params));
    const showIntertextAnyway = ref<boolean>(false);

    getIntertextDetail(routeParamToString(route.params.id));

    watch(
      () => route.params,
      () => {
        if (route.name === 'VerseIntertextDetail') {
          getIntertextDetail(routeParamToString(route.params.id));
        }

        verse.value = routeParamsToVerse(route.params);
      },
    );
    return {
      isLoading,
      intertextDetail,
      verse,
      verseInRange,
      showIntertextAnyway,
    };
  },
});
</script>
