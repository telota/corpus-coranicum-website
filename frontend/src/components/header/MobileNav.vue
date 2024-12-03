<template>
  <div class="z-50 absolute top-0 left-0 right-0 min-h-full">
    <CloseIcon
      class="w-16 cursor-pointer float-right"
      @click="$emit('close')"
    />
    <VerseLinks v-if="verseLinks" @linkClicked="$emit('close')" class="mt-16" />
    <NavLinks
      v-else
      :mobile="true"
      class="mt-16"
      @linkClicked="$emit('close')"
    />
  </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import NavLinks from '@/components/header/Navbar.vue';
import VerseLinks from '@/components/verse_navigation/VerseLinks.vue';
import CloseIcon from '@/components/icons/CloseIcon.vue';

export default defineComponent({
  components: { NavLinks, VerseLinks, CloseIcon },
  props: { verseLinks: Boolean },
});
</script>
