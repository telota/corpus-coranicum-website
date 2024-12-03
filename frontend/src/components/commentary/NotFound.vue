<template>
  <div class="text-center">
    <h3>{{$t('commentary.not_available')}}</h3>
    <br />
    <ListOfSuras />
  </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import ListOfSuras from '@/components/commentary/ListOfSuras.vue';

export default defineComponent({ components: { ListOfSuras } });
</script>
