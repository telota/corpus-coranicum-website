<template>
  <div>
    <router-link
      class="
        hover:bg-grey-light hover:text-black
        font-bold
        flex flex-col
        justify-center
        text-center
      "
      v-for="link in links"
      :key="link.label()"
      :to="link.to"
      :class="[
        link.active.includes($route.name) ? 'bg-grey-light text-black' : '',
        mobile ? 'py-6 px-8' : 'p-3',
      ]"
      @click="$emit('linkClicked')"
    >
      {{ link.label() }}
    </router-link>
  </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { useI18n } from 'vue-i18n';
import { verseLinks } from '@/components/verse_navigation/verse_links';

export default defineComponent({
  props: { mobile: Boolean },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });

    const links = verseLinks(t);
    return { links };
  },
});
</script>
