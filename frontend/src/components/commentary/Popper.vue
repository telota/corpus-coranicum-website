<template>
  <div
    id="tooltip"
    role="tooltip"
    class="
      block
      md:w-1/2
      w-3/4
      lg:max-width-screen-sm
      h-48
      overflow-y-auto
      bg-green-500
      text-white
      shadow
      p-2
      br-4
      font-size-14
      align-middle
    "
    @mouseenter="enteredPopper"
    @mouseleave="leftPopper"
  >
    <QuranVerses v-if="isLoaded(verseRange)" :verses="verseRange.payload" />
    <div v-else-if="payloadTooLarge(verseRange)">({{ $t('global.verse_range_too_large') }})</div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { isLoaded, payloadTooLarge } from '@/interfaces/RemoteData';
import QuranVerses from '@/components/commentary/QuranVerses.vue';
import { verseRange } from '@/api/verses';
import { enteredPopper, leftPopper } from './popper';

export default defineComponent({
  components: { QuranVerses },
  setup() {
    return {
      verseRange,
      payloadTooLarge,
      isLoaded,
      enteredPopper,
      leftPopper,
    };
  },
});
</script>
