<template>
  <router-link :to="'/' + $route.params.lang">
    <div class="relative flex flex-col justify-center h-full">
      <img class="flex-non h-20 ml-auto mr-3 font-bold" src="~@/assets/cc-logo.svg" />
    </div>
  </router-link>
</template>
<script lang="ts">
import { Vue } from 'vue-class-component';

export default class HomeArea extends Vue {}
</script>
