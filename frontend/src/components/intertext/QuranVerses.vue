<template>
  <template v-if="payloadTooLarge(verseRange)">{{$t('global.verse_range_too_large')}}</template>
  <template v-else>
    <h3 class="pt-5">{{ $t('print_edition.arabic_header') }}</h3>
    <p v-for="v in verseRange.payload" :key="v.arabic" class="arabic" dir="rtl">
      <sup class="pl-1">{{ `${v.sura}:${v.verse}` }}</sup>
      <span class="arabic text-2xl">{{ v.arabic }}</span>
    </p>
    <h3 class="pt-5">{{ $t('print_edition.translation_header') }}</h3>
    <p v-for="v in verseRange.payload" :key="v.translation">
      <sup class="pr-1">{{ `${v.sura}:${v.verse}` }}</sup>
      <span>{{ v.translation }}</span>
    </p>
  </template>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { payloadTooLarge } from '@/interfaces/RemoteData';
import { verseRange } from '@/api/verses';

export default defineComponent({
  setup() {
    return {
      verseRange, payloadTooLarge,
    };
  },
});
</script>
