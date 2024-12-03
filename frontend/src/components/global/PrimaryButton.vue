<template>
  <button
    class="bg-green-200 rounded h-12 w-48 text-center px-2"
    :class="disabled ? 'cursor-not-allowed text-white' : ''"
  >
    <slot></slot>
  </button>
</template>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({ props: { disabled: Boolean } });
</script>
