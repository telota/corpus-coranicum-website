<template>
  <figcaption
    v-if="imageCaption"
    class="showLinks text-center"
    :class="largeCaption ? 'text-lg' : 'text-xs'"
  >
    {{ $t('global.image_credits') }}
    <a v-if="imageCaptionLink" :href="imageCaptionLink" target="_blank">{{ imageCaption }}</a>
    <template v-else>{{ imageCaption }}</template>
  </figcaption>
</template>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    imageCaption: String,
    imageCaptionLink: String,
    largeCaption: Boolean,
  },
});
</script>
