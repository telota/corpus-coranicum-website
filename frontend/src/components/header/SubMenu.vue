<template>
  <div class="text-black bg-green-200" :class="mobile ? 'pl-16' : ''">
    <router-link
      v-for="link in links"
      :class="
        link.active.includes($route.name) ? 'text-black bg-green-200' : ''
      "
      :key="link.label()"
      :to="link.to"
      class="hover:bg-green-500 hover:text-grey-light block px-6 py-4 text-left"
      @click="$emit('clicked')"
    >
      {{ link.label() }}
    </router-link>
  </div>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import NavigationLink from '@/interfaces/NavigationLink';

export default defineComponent({
  props: {
    links: Object as PropType<NavigationLink[]>, mobile: Boolean,
  },
  emits: ['clicked'],
});
</script>
