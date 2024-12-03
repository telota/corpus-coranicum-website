<template>
  <tr :class="color(odd, variant.work)">
    <td
      class="
        whitespace-nowrap
        border-r border-black
        text-left
        align-top
        bg-clip-padding
        lg:sticky
        left-0
        z-10
        w-96
        max-w-sm
      "
      :class="color(odd, variant.work)"
    >
      <div class="flex h-10 items-center">
        <span class="flex-grow">{{ variant.work.display_name }}</span>
        <MoreInfo class="mx-1 border text-black" :showInfo="!!selectedWork" @click="toggleWork" />
      </div>
      <InfoTable v-if="selectedWork" :work="selectedWork" class="max-w-sm" />
    </td>
    <td
      class="
        whitespace-nowrap
        align-top
        border-r border-black
        bg-clip-padding
        lg:sticky
        z-10
        w-96
        max-w-sm
        h-auto
      "
      :class="color(odd, variant.work)"
      :style="freezeWidth ? { left: freezeWidth + 'px' } : {}"
    >
      <div v-for="r in variant.readers" :key="r.sigle" class="max-w-sm text-left">
        <div
          class="text-left flex items-center "
          :class="variant.work.canonical === 1 && +r.sigle % 100 > 0 ? 'pl-6' : ''"
        >
        <div class="flex-grow overflow-hidden mb-3">
          <span class="text-pretty break-words whitespace-normal py-10"
          >{{ toDisplayName(variant.work, r) }}</span>
          </div>
          <MoreInfo
            class="mx-1 border text-black"
            :showInfo="selectedReader && selectedReader.id === r.id"
            @click="toggleReader(r)"
          />
        </div>
        <InfoTable
          v-if="selectedReader && selectedReader.id === r.id"
          :reader="selectedReader"
        />
        <SmallToggleButton
          class="bg-green-200 mb-2 inline-block ml-auto mr-1 border"
          v-if="variant.reading_commentary"
          @click="toggleCommentary"
          :open="showCommentary"
          :text="$t('variants.show_commentary')"
        />
        <div
          v-if="showCommentary"
          class="whitespace-normal text-left"
          v-html="variant.reading_commentary"
        />
      </div>
    </td>
    <td
      class="whitespace-nowrap p-1"
      v-for="index in Array.from({length: verseCount}, (_, i) => i + 1)"
      :key="index"
      :class="[
        selectedWord == index - 1 ? 'bg-green-200' : '',
        variant.work.canonical === 1 ? 'border-t border-black' : '',
      ]"
    >
      {{ variant?.variants[index] }}
    </td>
  </tr>
</template>
<script lang="ts">
import { defineComponent, PropType, ref } from 'vue';
import { VariantsReading } from '@/interfaces/VariantsReading';
import MoreInfo from '@/components/global/MoreInfo.vue';
import SmallToggleButton from '@/components/global/SmallToggleButton.vue';
import InfoTable from '@/components/variants/InfoTable.vue';
import { VariantsWork } from '@/interfaces/VariantsWork';
import { VariantsReader } from '@/interfaces/VariantsReader';
import { selectedWord } from '@/api/variants';

export default defineComponent({
  props: {
    variant: Object as PropType<VariantsReading>,
    odd: Boolean,
    verseCount: Number,
    freezeWidth: Number,
  },
  components: {
    MoreInfo,
    InfoTable,
    SmallToggleButton,
  },
  setup(props) {
    const selectedReader = ref<VariantsReader | undefined>(undefined);
    const selectedWork = ref<VariantsWork | undefined>(undefined);

    const showCommentary = ref<boolean>(false);
    function toggleCommentary() {
      showCommentary.value = !showCommentary.value;
    }

    function toDisplayName(s: VariantsWork, r: VariantsReader): string {
      if (s.canonical === 1 && +r.sigle % 100 === 0) {
        return `${+r.sigle / 100} ${r.display_name}`;
      }
      return r.display_name;
    }

    function toggleReader(r: VariantsReader) {
      if (selectedReader.value && selectedReader.value.id === r.id) {
        selectedReader.value = undefined;
      } else {
        selectedReader.value = r;
      }
    }
    function toggleWork() {
      if (selectedWork.value) {
        selectedWork.value = undefined;
      } else {
        selectedWork.value = props.variant?.work;
      }
    }

    function color(odd: boolean, source: VariantsWork): string {
      if (source.canonical === 1) {
        return 'bg-green-500 text-white text-bold border-t border-black';
      }
      if (odd) {
        return 'bg-white';
      }
      return 'bg-grey-light';
    }

    return {
      color,
      showCommentary,
      toggleCommentary,
      selectedWord,
      selectedWork,
      selectedReader,
      toggleReader,
      toggleWork,
      toDisplayName,
    };
  },
});
</script>
