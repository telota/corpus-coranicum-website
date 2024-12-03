<template>
  <div id="contentHeadline" class="flex flex-wrap sm:flex-nowrap pt-5 pb-3 justify-center">
    <h1 itemprop="headline" class="mr-1 text-center">
      <template v-if="$slots.title">
        <slot name="title"></slot>
      </template>
      <template v-else-if="title">
        {{ title }}
      </template>
      <small class="ml-7"><slot name="subtitle"></slot></small>
    </h1>
    <MoreInfo
      v-if="infoText"
      class="self-start ml-3 mr-3 mt-2"
      :showInfo="showInfo"
      @click="showInfo = !showInfo"
    />
  </div>
  <div
    :class="showInfo ? 'max-h-96 overflow-y-auto' : 'overflow-hidden max-h-0'"
    class="max-w-screen mx-auto transition transition-ease-in duration-500 transition-maxHeight"
  >
    <div class="bg-grey-verylight max-w-screen-md mx-auto rounded p-7 my-3" v-html="infoText" />
  </div>
</template>
<script lang="ts">
import { defineComponent, ref } from 'vue';
import MoreInfo from '@/components/global/MoreInfo.vue';

export default defineComponent({
  components: { MoreInfo },
  props: {
    title: String,
    infoText: String,
  },
  setup() {
    const showInfo = ref(false);
    return { showInfo };
  },
});
</script>
