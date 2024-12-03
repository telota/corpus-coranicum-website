<template>
  <Card :title="$t('intertext.quran_passages')" :informationText="infoText">
    <div class="px-3 py-5">
      <label class="font-bold" for="range">{{ $t('intertext.selected') }}</label>
      <select
        class="w-48 ml-2 mr-4 bg-green-200 border"
        name="range"
        id="range"
        v-model="selectedRange"
      >
        <option :value="-1">{{ $t('intertext.select') }}</option>
        <option
          v-for="(range, index) in intertextDetail.payload.passages"
          :key="JSON.stringify(range)"
          :value="index"
        >
          {{ toText('Verse', 'Verses', range) }}
        </option>
      </select>
      <QuranVerses v-if="selectedRange >= 0" />
    </div>
  </Card>
</template>
<script lang="ts">
import { computed, defineComponent, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { intertextDetail } from '@/api/intertext';
import { getVerses, verseRange } from '@/api/verses';
import { intertextWeb } from '@/api/web';
import { isLoaded } from '@/interfaces/RemoteData';
import { Verse } from '@/interfaces/Verse';
import { toText, verseInRange } from '@/interfaces/VerseRange';
import routeParamToString from '@/router/param_as_string';
import { routeParamsToVerse } from '@/router/route_to_verse';
import QuranVerses from '@/components/intertext/QuranVerses.vue';
import Card from '@/components/global/Card.vue';
import { useI18n } from 'vue-i18n';

export default defineComponent({
  components: {
    Card,
    QuranVerses,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();
    const verse = ref<Verse>(routeParamsToVerse(route.params));
    const selectedRange = ref<number>(-1);

    watch([selectedRange, () => route.params.lang], () => {
      if (selectedRange.value >= 0 && isLoaded(intertextDetail.value)) {
        getVerses(
          routeParamToString(route.params.lang),
          intertextDetail.value.payload.passages[selectedRange.value],
        );
      }
    });

    if (isLoaded(intertextDetail.value)) {
      const { passages } = intertextDetail.value.payload;
      const selected = passages.findIndex((p) => verseInRange(verse.value)(p));
      selectedRange.value = selected;
      if (selected > 0) {
        getVerses(routeParamToString(route.params.lang), passages[selectedRange.value]);
      }
    }

    const infoText = computed(() => {
      if (isLoaded(intertextWeb.value)) {
        return `${t('print_edition.arabic_header')}: ${
          intertextWeb.value.payload.arabic_text_info
        }<br><br> ${t('print_edition.translation_header')}: ${
          intertextWeb.value.payload.translation_info
        }`;
      }
      return '';
    });

    return {
      isLoaded,
      selectedRange,
      verseRange,
      toText,
      intertextDetail,
      infoText,
    };
  },
});
</script>
