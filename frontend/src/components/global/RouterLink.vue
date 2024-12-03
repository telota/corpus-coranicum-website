<template>
  <router-link :to="to">{{ content }}</router-link>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { RouteLocation } from 'vue-router';

export default defineComponent({
  props: { to: Object as PropType<RouteLocation>, content: String },
  setup() {
    console.log('');
  },
});
</script>
