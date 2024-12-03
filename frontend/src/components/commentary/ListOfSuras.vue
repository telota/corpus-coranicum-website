<template>
  <h3 class="text-center">{{ $t('commentary.available_commentary') }}</h3>
  <div v-if="isLoaded(available)" class="flex flex-wrap max-w-sm mx-auto py-6 showLinks">
    <router-link
      class="w-12 text-left p-2"
      v-for="sura in available.payload"
      :key="sura"
      :to="{
        name: 'VerseCommentary',
        params: {
          sura: sura,
          verse: 1,
        },
      }"
      >{{ sura }}</router-link
    >
  </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { getAvailable, available } from '@/api/commentary';
import { isLoaded } from '@/interfaces/RemoteData';

export default defineComponent({
  setup() {
    getAvailable();
    return {
      available,
      isLoaded,
    };
  },
});
</script>
