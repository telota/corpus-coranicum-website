<template>
  <li>
    <a :href="`#${item.link}`">{{ item.text }} </a>
    <ul
      v-if="item.children && item.children.length > 0"
      class="list-disc list-outside"
      :class="`ml-${depth * 12}`"
    >
      <TableOfContentsItem
        v-for="child in item.children"
        :key="child.link"
        :item="child"
        :depth="depth + 1"
      />
    </ul>
  </li>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { TableOfContentsItem } from '@/interfaces/TableOfContentsItem';

export default defineComponent({
  name: 'TableOfContentsItem',
  components: {},
  props: {
    depth: Number,
    item: Object as PropType<TableOfContentsItem>,
  },
});
</script>
