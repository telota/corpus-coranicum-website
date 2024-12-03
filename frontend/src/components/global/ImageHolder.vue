<template>
  <figure class="relative" ref="imgHolder">
    <div id="for-image-vertical-centering" class="h-full">
      <span id="vertical-centering-element" class="inline-block align-middle h-full" />
      <img
        class="inline-block max-h-full"
        :style="isLoaded ? '' : { height: loadingHeight + 'px' }"
        :key="imageUrl"
        :src="imageUrl"
        :alt="imageDescription"
        @load="isLoaded = true"
        @error="isError = true"
      />
    </div>
    <FigureCaption
      :imageCaption="imageCaption"
      :imageCaptionLink="imageCaptionLink"
      :largeCaption="largeCaption"
    />
    <LoadingSpinner v-if="!isLoaded && !isError" class="absolute top-1/2 left-1/2 z-10" />
  </figure>
</template>
<script lang="ts">
import { computed, defineComponent, ref, watch } from 'vue';
import LoadingSpinner from '@/components/global/LoadingSpinner.vue';
import FigureCaption from '@/components/global/FigureCaption.vue';

export default defineComponent({
  components: {
    LoadingSpinner, FigureCaption,
  },
  props: {
    imageRatio: Number,
    imageUrl: String,
    imageDescription: String,
    imageCaption: String,
    imageCaptionLink: String,
    largeCaption: Boolean,
  },
  setup(props) {
    const isLoaded = ref(false);
    const isError = ref(false);

    watch(
      () => props.imageUrl,
      () => {
        isLoaded.value = false;
      },
    );

    const imgHolder = ref<HTMLElement | null>(null);

    const loadingHeight = computed(() => {
      if (props.imageRatio && imgHolder.value) {
        return imgHolder.value?.clientWidth * props.imageRatio;
      }
      return 50;
    });

    return {
      isError,
      isLoaded,
      imgHolder,
      loadingHeight,
    };
  },
});
</script>
