<template>
  <nav :class="mobile ? 'overflow-y-auto' : 'flex items-end '">
    <div
      v-for="(link, index) in links"
      :key="link.label()"
      class="
        font-bold
        whitespace-nowrap
        cursor-pointer
        relative
        hover:bg-green-500 hover:text-grey-light
      "
    >
      <router-link
        v-if="link.to"
        @click="closeMenus"
        class="px-8 py-4 block text-left"
        :class="link.active.includes($route.name) ? 'text-grey-light bg-green-500' : ''"
        :key="link.label()"
        :to="link.to"
      >
        {{ link.label() }}
      </router-link>
      <div
        v-else
        class="relative pl-8 pr-6 py-4 text-left whitespace-nowrap"
        @click="open === index ? (open = undefined) : (open = index)"
        :class="link.active.includes($route.name) ? 'text-grey-light bg-green-500' : ''"
      >
        <span>
          {{ link.label() }}
        </span>
        <ArrowIcon class="inline-block ml-1" v-if="index !== open" type="down" :width="18" />
        <ArrowIcon class="inline-block ml-1" v-else type="up" :width="18" />
      </div>
      <SubMenu
        v-if="link.children && open === index"
        @clicked="closeMenus"
        :class="mobile ? '' : 'absolute'"
        :links="link.children"
        :mobile="mobile"
        class="z-50"
      />
    </div>
    <LanguageMenu
      v-if="mobile"
      @selected="closeMenus"
      class="flex align-middle text-black ml-6 mt-4"
    />
  </nav>
</template>
<script lang="ts">
import { computed, defineComponent, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import NavigationLink from '@/interfaces/NavigationLink';
import mainLinks from '@/components/header/main_links';
import LanguageMenu from '@/components/header/LanguageMenu.vue';
import SubMenu from '@/components/header/SubMenu.vue';
import ArrowIcon from '@/components/icons/ArrowIcon.vue';
import { useRoute } from 'vue-router';

export default defineComponent({
  components: {
    SubMenu,
    ArrowIcon,
    LanguageMenu,
  },
  props: { mobile: Boolean },
  setup(props, context) {
    const {
      t, locale,
    } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const route = useRoute();
    const open = ref<number | undefined>(undefined);

    const links = computed(() => mainLinks(t, route, locale));

    function closeMenus() {
      open.value = undefined;
      context.emit('linkClicked');
    }
    return {
      links,
      open,
      closeMenus,
    };
  },
});
</script>
