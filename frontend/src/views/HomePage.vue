<template>
  <h1 class="mx-auto text-center pt-10">
    This page is currently under construction.
  </h1>
  <h2 class="mx-auto text-center py-10">Please check back later.</h2>
  <img class="mx-auto pb-10" src="~@/assets/blauer-bagger.jpg" alt="" />
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { useRouter } from 'vue-router';

export default defineComponent({
  setup() {
    const router = useRouter();
    console.log(router.options.routes);
  },
});
</script>
