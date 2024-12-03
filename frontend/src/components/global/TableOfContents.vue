<template>
  <ArticleContainer class="showLinks block" id="table_of_contents">
    <h2 class="text-center">{{ $t('global.table_of_contents') }}</h2>
    <ul class="list-disc list-inside">
      <TableOfContentsItemComp v-for="item in listing" :key="item.link" :item="item" :depth="1" />
    </ul>
  </ArticleContainer>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import TableOfContentsItemComp from '@/components/global/TableOfContentsItem.vue';
import { TableOfContentsItem } from '@/interfaces/TableOfContentsItem';

export default defineComponent({
  components: {
    ArticleContainer, TableOfContentsItemComp,
  },
  props: {
    listing: Array as PropType<TableOfContentsItem[]>,
  },
});
</script>
