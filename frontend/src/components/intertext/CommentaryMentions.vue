<template>
  <Card
    :title="$t('intertext.commentaries')"
    :informationText="intertextWeb.payload?.commentary_info"
  >
    <router-link
      v-for="s in intertextDetail.payload?.sura_commentaries"
      :key="s"
      :to="{ name: 'VerseCommentary', params: { sura: s, verse: 1 } }"
      class="block p-3"
      >{{ $t('intertext.commentary', { sura: s }) }}</router-link
    >
    <p v-if="intertextDetail.payload?.sura_commentaries.length === 0" class="p-3">
      {{ $t('intertext.commentary_no_mention') }}
    </p>
  </Card>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { intertextDetail } from '@/api/intertext';
import Card from '@/components/global/Card.vue';
import { intertextWeb } from '@/api/web';

export default defineComponent({
  components: { Card },
  setup() {
    return {
      intertextDetail,
      intertextWeb,
    };
  },
});
</script>
