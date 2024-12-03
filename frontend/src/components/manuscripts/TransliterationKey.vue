<template>
  <div>
    <table class="border">
      <tr class="border">
        <th class="border">{{ $t('manuscripts.mark') }}</th>
        <th class="border">{{ $t('manuscripts.meaning') }}</th>
      </tr>
      <tr v-for="mark in markings" :key="mark.id" class="border">
        <td :class="mark.id" class="border h-24 text-center">
          {{ $t(`manuscripts.markings.${mark.id}`) }}
        </td>
        <td class="h-24 border">
          {{ $t(`manuscripts.markings.${mark.id}_explanation`) }}
        </td>
      </tr>
    </table>
  </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  setup() {
    const markings = [
      { id: 'unavailable' },
      { id: 'unclear' },
      { id: 'missing' },
      { id: 'added' },
      { id: 'variation' },
      { id: 'modified' },
      { id: 'erased' },
    ];
    return { markings };
  },
});
</script>
