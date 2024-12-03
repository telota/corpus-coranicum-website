<template>
  <table>
    <tr v-for="v in verses" :key="v.arabic" class="">
      <td class="align-top">
        <sup class="pt-2">{{ `${v.sura}:${v.verse}` }}</sup>
      </td>
      <td>
        <span>{{ v.transcription }}</span
        ><br />
        <span>{{ v.translation }}</span>
      </td>
    </tr>
  </table>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { VerseTranslation } from '@/interfaces/VerseTranslaton';

export default defineComponent({ props: { verses: Array as PropType<Array<VerseTranslation>> } });
</script>
