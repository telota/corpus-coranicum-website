<template>
  <nav class="bg-green-500 flex justify-center w-full">
    <div class="xl:flex flex-row-reverse container mx-auto w-full items-center">
      <VerseSelect class="self-center pl-2 text-grey-light" />
      <MenuIcon
        class="md:hidden cursor-pointer h-16 ml-auto text-grey-light"
        @click="mobileMenu = true"
        :verseLinks="true"
      />
      <VerseLinks
        :mobile="false"
        class="text-grey-light hidden md:flex w-full xl:justify-start justify-start h-12"
      />
    </div>
    <MobileNav
      v-if="mobileMenu"
      :verseLinks="true"
      @close="mobileMenu = false"
      class="bg-green-800"
    />
  </nav>
</template>
<script lang="ts">
import { defineComponent, Ref, ref } from 'vue';
import VerseSelect from '@/components/verse_navigation/VerseSelect.vue';
import VerseLinks from '@/components/verse_navigation/VerseLinks.vue';
import MenuIcon from '@/components/icons/MenuIcon.vue';
import MobileNav from '@/components/header/MobileNav.vue';

export default defineComponent({
  components: {
    VerseSelect,
    VerseLinks,
    MenuIcon,
    MobileNav,
  },
  setup() {
    const mobileMenu: Ref<boolean> = ref(false);

    return { mobileMenu };
  },
});
</script>
