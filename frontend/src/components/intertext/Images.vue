<template>
  <ScrollCard :title="$tc('intertext.images', images.length)">
    <div
      v-for="(image, index) in images"
      :key="image.url"
      class="p-2"
      :class="index > 0 ? 'pt-12' : ''"
    >
      <ImageHolder
        :imageUrl="image.url"
        :imageDescription="image.credits"
        :imageRatio="2"
        class="mx-auto"
        style="min-height: 24rem"
      />
      <p class="max-w-xl block m-auto">{{ image.credits }}</p>
    </div>
  </ScrollCard>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { IntertextImage } from '@/interfaces/IntertextImage';
import ImageHolder from '@/components/global/ImageHolder.vue';
import ScrollCard from '../global/ScrollCard.vue';

export default defineComponent({
  components: {
    ScrollCard,
    ImageHolder,
  },
  props: { images: Object as PropType<IntertextImage> },
});
</script>
