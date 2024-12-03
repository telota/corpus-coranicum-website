<template>
  <div>
    <h3>{{ title }}</h3>
    <div v-html="body" class="pb-6 showLinks spaceParagraphs" />
  </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    title: String, body: String,
  },
});
</script>
