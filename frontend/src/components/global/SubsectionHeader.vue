<template>
  <h2 class="py-3 text-center">{{ title }}</h2>
</template>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({ props: { title: String } });
</script>
