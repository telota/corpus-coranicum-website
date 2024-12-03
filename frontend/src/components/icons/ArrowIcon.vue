<template>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    :width="width"
    viewBox="0 0 512 512"
  >
    <path
      fill="none"
      stroke="currentColor"
      stroke-linecap="round"
      stroke-linejoin="round"
      stroke-width="40"
      :d="path"
    />
  </svg>
</template>
<script lang="ts">
import { Options, Vue } from 'vue-class-component';

@Options({
  name: 'ArrowIcon',
  props: {
    type: String,
    width: Number,
  },
})
export default class ArrowIcon extends Vue {
  type!: string;

  get path(): string {
    switch (this.type) {
      case 'back':
        return 'M328 112L184 256l144 144';
      case 'forward':
        return 'M184 112l144 144-144 144';
      case 'up':
        return 'M112 328l144-144 144 144';
      case 'down':
        return 'M112 184l144 144 144-144';
      default:
        return '';
    }
  }
}
</script>
