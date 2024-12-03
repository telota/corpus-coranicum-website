<template>
  <PrimaryButton>
    <router-link v-if="internalLink" :to="internalLink">
      <PlayButtonContent
        :arrowType="arrowType"
        :text="text"
        :textFirst="textFirst"
      />
    </router-link>
    <PlayButtonContent
      v-else
      :arrowType="arrowType"
      :text="text"
      :textFirst="textFirst"
      :class="disabled ? 'text-white cursor-not-allowed' : ''"
    />
  </PrimaryButton>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { RouteLocationRaw } from 'vue-router';
import PrimaryButton from '@/components/global/PrimaryButton.vue';
import PlayButtonContent from '@/components/global/PlayButtonContent.vue';

export default defineComponent({
  components: {
    PrimaryButton,
    PlayButtonContent,
  },
  props: {
    disabled: Boolean,
    arrowType: String,
    text: String,
    textFirst: Boolean,
    internalLink: Object as PropType<RouteLocationRaw>,
  },
});
</script>
