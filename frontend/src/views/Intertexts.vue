<template>
    <SectionHeader :infoText="intertextWeb.payload?.introduction_general">
  <template v-slot:title>
    <span v-html="$t('intertext.title') + ' <small>' + $t('global.sura') + ' '
+ $route.params.sura  + ' ' + $t('global.verse') + ' ' +
$route.params.verse + '</small>'"></span>
  </template>
</SectionHeader>
  <PrimaryButton v-if="$route.name === 'VerseIntertextDetail'" class="text-black w-72 my-5 ml-auto">
    <router-link
      :to="{ name: 'VerseIntertextResults' }"
      class="grid place-content-center text-black h-full w-full"
    >
      To List of Intertexts for this Verse
    </router-link>
  </PrimaryButton>
  <router-view></router-view>
</template>
<script lang="ts">
import { defineComponent, computed } from 'vue';
import { useRoute } from 'vue-router';
import SectionHeader from '@/components/global/SectionHeader.vue';
import PrimaryButton from '@/components/global/PrimaryButton.vue';
import { webWatcher, intertextWeb } from '@/api/web';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';

export default defineComponent({
  components: {
    SectionHeader,
    PrimaryButton,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();

    const title = computed(
      () => `${t('navigation.intertexts')} ${t('global.sura')} ${route.params.sura} ${t('global.verse')} ${route.params.verse}`,
    );
    const description = computed(
      () => `${t('navigation.intertexts')} ${t('global.sura')} ${route.params.sura} ${t('global.verse')} ${route.params.verse}`,
    );
    const canonical = computed(
      () => `https://corpuscoranicum.de/${route.params.lang}/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/intertexts`,
    );
    const alternate_de = computed(
      () => `https://corpuscoranicum.de/de/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/intertexts`,
    );
    const alternate_en = computed(
      () => `https://corpuscoranicum.de/en/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/intertexts`,
    );
    const alternate_fr = computed(
      () => `https://corpuscoranicum.de/fr/verse-navigator/sura/${route.params.sura}/verse/${route.params.verse}/intertexts`,
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
    return { intertextWeb };
  },
});
</script>
