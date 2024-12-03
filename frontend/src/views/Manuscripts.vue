<template>
  <SectionHeader :title="$t('navigation.manuscripts')" />
  <router-view></router-view>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import SectionHeader from '@/components/global/SectionHeader.vue';

export default defineComponent({
  components: { SectionHeader },
  setup() {
    // const route = useRoute();
    return {};
  },
});
</script>
