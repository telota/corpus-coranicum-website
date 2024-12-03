<template>
  <table class="table-auto">
    <tbody>
      <tr v-for="f in fields" :key="f[0]" class="">
        <td class="align-top">{{ f[0] }}:</td>
        <td class="align-bottom pl-2" v-html="f[1]" />
      </tr>
    </tbody>
  </table>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';

export default defineComponent({ props: { fields: Array as PropType<[string, string][]> } });
</script>
