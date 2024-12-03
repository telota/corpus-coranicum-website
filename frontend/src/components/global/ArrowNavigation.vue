<template>
  <div class="flex justify-center flex-wrap w-full p-0">
    <PlayButton
      class="md:order-1 order-2 my-2"
      :text="textLeft"
      arrowType="back"
      :textFirst="false"
      :internalLink="leftLink"
      :disabled="!leftLink"
    />
    <div class="md:order-2 order-1 w-full md:w-min flex-grow my-2 text-center">
      <router-link v-if="middleLink" :to="middleLink">
        <PrimaryButton class="w-72 mb-2">
          {{ textMiddle }}
        </PrimaryButton>
      </router-link>
    </div>

    <PlayButton
      class="md:order-3 order-2 my-2"
      :text="textRight"
      arrowType="forward"
      :textFirst="true"
      :internalLink="rightLink"
      :disabled="!rightLink"
    />
  </div>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { RouteLocationRaw } from 'vue-router';
import PlayButton from '@/components/global/PlayButton.vue';
import PrimaryButton from '@/components/global/PrimaryButton.vue';

export default defineComponent({
  components: { PlayButton, PrimaryButton },
  props: {
    textLeft: String,
    textMiddle: String,
    textRight: String,
    leftLink: Object as PropType<RouteLocationRaw>,
    middleLink: Object as PropType<RouteLocationRaw>,
    rightLink: Object as PropType<RouteLocationRaw>,
  },
});
</script>
