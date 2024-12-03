<template>
  <router-link
    :to="{
      name: 'VerseIntertextDetail',
      params: {
        sura: intertext.sura,
        verse: intertext.verse,
        id: intertext.id,
      },
    }"
    ><p>{{ `${intertext.title} (TUK ${intertext.id})` }}</p>
  </router-link>
</template>
<script lang="ts">
import { IntertextShort } from '@/interfaces/IntertextShort';
import { defineComponent, PropType } from 'vue';

export default defineComponent({ props: { intertext: Object as PropType<IntertextShort> } });
</script>
