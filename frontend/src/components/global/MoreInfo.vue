<template>
  <SmallToggleButton :text="$t('global.info')" :open="showInfo"/>
</template>
<script>
import SmallToggleButton from '@/components/global/SmallToggleButton.vue';

export default {
  components: { SmallToggleButton },
  props: { showInfo: { type: Boolean } },
};
</script>
