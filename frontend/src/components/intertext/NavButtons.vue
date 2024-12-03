<template>
  <div class="flex justify-center w-full py-3">
    <router-link :to="{ name: 'VerseIntertextResults' }">
      <PrimaryButton class="text-black w-72">
        To List of Intertexts for this Verse
      </PrimaryButton>
    </router-link>
  </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import PrimaryButton from '@/components/global/PrimaryButton.vue';

export default defineComponent({ components: { PrimaryButton } });
</script>
