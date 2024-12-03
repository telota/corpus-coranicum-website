<template>
  <SmallButton class="bg-green-200 flex flex-row">
    {{text}}
    <ArrowIcon v-if="!open" type="down" :width="18" class="ml-1" />
    <ArrowIcon v-else type="up" :width="18" class="ml-1" />
  </SmallButton>
</template>
<script>
import ArrowIcon from '@/components/icons/ArrowIcon.vue';
import SmallButton from '@/components/global/SmallButton.vue';

export default {
  components: { ArrowIcon, SmallButton },
  props: { open: Boolean, text: String },
};
</script>
