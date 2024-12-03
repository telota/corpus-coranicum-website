<template>
  <nav class="w-full">
    <HomeArea />
    <MenuIcon
      class="w-16 absolute top-0 right-2 cursor-pointer z-20"
      @click="toggle"
    />
    <MobileNav v-if="mobileMenu" @close="toggle()" />
  </nav>
</template>
<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import HomeArea from '@/components/header/HomeArea.vue';
import MobileNav from '@/components/header/MobileNav.vue';
import MenuIcon from '@/components/icons/MenuIcon.vue';

@Options({
  components: {
    HomeArea,
    MenuIcon,
    MobileNav,
  },
})
export default class MobileHeader extends Vue {
  mobileMenu = false;

  toggle(): void {
    this.mobileMenu = !this.mobileMenu;
  }
}
</script>
