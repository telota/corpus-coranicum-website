<template>
  <Card :title="title" :informationText="informationText" class="relative">
    <div
      class="p-3"
      :class="[open ? '' : 'h-40 overflow-y-auto', isOverflowing ? 'pb-8' : '']"
      ref="container"
    >
      <div
        v-if="htmlContent"
        v-html="htmlContent"
        :dir="direction"
        :class="direction == 'rtl' ? 'arabic' : ''"
      />
      <slot v-else></slot>
    </div>
    <div
      v-if="isOverflowing"
      @click="open = !open"
      class="
        px-3
        text-xl
        bg-green-800
        text-center text-white
        bg-opacity-70
        absolute
        left-0
        right-0
        bottom-3
        align-bottom
        cursor-pointer
      "
    >
      {{ open ? $t('global.close') : $t('global.expand') }}
      <ArrowIcon v-if="!open" type="down" :width="18" class="inline" />
      <ArrowIcon v-else type="up" :width="18" class="inline" />
    </div>
  </Card>
</template>
<script lang="ts">
import { computed, defineComponent, ref } from 'vue';
import Card from '@/components/global/Card.vue';
import ArrowIcon from '@/components/icons/ArrowIcon.vue';

export default defineComponent({
  components: {
    Card,
    ArrowIcon,
  },
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
    htmlContent: {
      type: String,
      required: false,
    },
    direction: {
      type: String,
      required: false,
    },
  },
  setup() {
    const container = ref<HTMLElement | null>(null);
    const open = ref(false);

    const isOverflowing = computed(() => {
      if (container.value) {
        return container.value.offsetHeight < container.value.scrollHeight;
      }
      return false;
    });

    return {
      open,
      container,
      isOverflowing,
    };
  },
});
</script>
