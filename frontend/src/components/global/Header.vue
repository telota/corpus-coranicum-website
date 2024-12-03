<template>
  <div class="bg-green-200 text-center flex justify-center h-24">
    <MobileNav v-if="mobileMenu" @close="mobileMenu = false" class="bg-green-200" />
    <div class="bg-green-200 flex justify-end md:justify-start w-full container mx-auto">
      <NavBar class="md:flex hidden flex-grow" />
      <LanguageMenu class="md:block hidden self-end my-4 mx-4" />
      <MenuIcon class="md:hidden cursor-pointer h-24" @click="mobileMenu = true" />
      <HomeArea class="md:flex-grow-0 flex-grow" />
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent, ref, Ref } from 'vue';
import HomeArea from '@/components/header/HomeArea.vue';
import NavBar from '@/components/header/Navbar.vue';
import LanguageMenu from '@/components/header/LanguageMenu.vue';
import MenuIcon from '@/components/icons/MenuIcon.vue';
import MobileNav from '@/components/header/MobileNav.vue';

export default defineComponent({
  components: {
    HomeArea,
    NavBar,
    LanguageMenu,
    MenuIcon,
    MobileNav,
  },
  setup() {
    const mobileMenu: Ref<boolean> = ref(false);

    return { mobileMenu };
  },
});
</script>
