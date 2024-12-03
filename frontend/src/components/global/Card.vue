<template>
  <div class="w-full flex-column py-3">
    <div class="py-1 px-3 text-xl bg-white shadow">
      <div class="flex flex-row">
        <h3 class="text-black">{{ title }}</h3>
          <MoreInfo
            v-if="informationText"
            :showInfo="showInfo"
            @click="showInfo = !showInfo"
            class="ml-4"
          />
      </div>
      <p class="" v-if="subtitle" v-html="subtitle"/>
    </div>
    <div
      :class="showInfo ? 'max-h-large' : 'max-h-0'"
      class="
        text-m
        overflow-hidden
        transition transition-maxHeight ease-in-out
        duration-700
      "
    >
      <div class="bg-grey-verylight px-3 py-5" v-html="informationText"/>
    </div>
    <div class="bg-white flex-grow">
      <slot />
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import MoreInfo from '@/components/global/MoreInfo.vue';

export default defineComponent({
  components: { MoreInfo },
  props: {
    title: String,
    subtitle: {
      type: String,
      required: false,
    },
    informationText: {
      type: String,
      required: false,
    },
  },
  setup() {
    const showInfo = ref(false);

    return { showInfo };
  },
});
</script>
