<template>
  <li
    v-if="value !== null && value !== '' && name !== 'analysis' && name !== 'word'"
    class="leading-10 align-middle"
  >
    <div v-if="Object.values(WordType).includes(name)">
      <div class="flex flex-row items-center">
        <span :class="`concordance-${name}`">
          {{ $t('concordance.'+name) }}:
          {{ value }}</span
        >
        <SmallToggleButton
          :text="`${$t('concordance.occurrences')}: ` + occurrences?.length"
          :open="open"
          class="ml-4 align-middle"
          @click="open = !open"
          v-if="occurrences"
        />
      </div>
      <CorrespondingVerses
        :verses="formattedOccurrences"
        :class="occurrences && open ? 'max-h-80' : 'max-h-0'"
        class="overflow-y-auto transition transition-maxHeight duration-700 bg-parchment"
      />
    </div>
    <span :class="`concordance-${name}`" v-else> {{ $t('concordance.' + name) }}: {{ value }}</span>
  </li>
</template>
<script lang='ts'>
import { computed, DeepReadonly, defineComponent, PropType, Ref, ref, watchEffect } from 'vue';
import { useI18n } from 'vue-i18n';
import { useRoute } from 'vue-router';
import { WordType, makeWordLabel } from '@/interfaces/ConcordanceWordType';
import SmallToggleButton from '@/components/global/SmallToggleButton.vue';
import CorrespondingVerses from '@/components/concordance/CorrespondingVerses.vue';
import { isLoaded, RemoteData } from '@/interfaces/RemoteData';
import mapToReferences from '@/components/concordance/makeVerses';
import { wordRefs, baseRefs, rootRefs } from '@/api/concordance';
import { ConcordanceVerse } from '@/interfaces/ConcordanceVerse';
import { ConcordanceAnalyis } from '@/interfaces/ConcordanceAnalysis';

export default defineComponent({
  components: {
    SmallToggleButton,
    CorrespondingVerses,
  },
  props: {
    name: String,
    value: [String, Number],
    fullAnalysis: Object as PropType<ConcordanceAnalyis>,
  },
  setup(props) {
    const route = useRoute();
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const open = ref(false);
    const occurrences: Ref<DeepReadonly<ConcordanceVerse[]> | undefined> = ref(undefined);

    watchEffect(() => {
      let references: DeepReadonly<Ref<RemoteData<ConcordanceVerse[]>>> | undefined;
      if (props.name === 'word_cc') {
        references = wordRefs;
      } else if (props.name === 'base_cc') {
        references = baseRefs.get(String(props.value));
      } else if (props.name === 'root_cc') {
        references = rootRefs.get(String(props.value));
      }

      if (references && isLoaded(references.value)) {
        occurrences.value = references.value.payload.slice();
      } else {
        occurrences.value = undefined;
        open.value = false;
      }
    });

    const formattedOccurrences = computed(() => {
      if (occurrences.value && occurrences) {
        return mapToReferences(t('global.sura'), t('global.verse'), occurrences.value);
      }
      return [];
    });

    return {
      route,
      t,
      isLoaded,
      WordType,
      makeWordLabel,
      occurrences,
      open,
      formattedOccurrences,
    };
  },
});
</script>
