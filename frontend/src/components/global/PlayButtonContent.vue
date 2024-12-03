<template>
  <div>
    <span class="inline" v-if="textFirst">{{ text }}</span>
    <ArrowIcon :type="arrowType" :width="32" class="inline h-12" />
    <span class="inline" v-if="!textFirst">{{ text }}</span>
  </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import ArrowIcon from '@/components/icons/ArrowIcon.vue';

export default defineComponent({
  components: { ArrowIcon },
  props: {
    arrowType: String,
    text: String,
    textFirst: Boolean,
  },
});
</script>
