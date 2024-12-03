<template>
  <ArticleContainer
    v-for="([key, intertexts], index) in byCategory.entries()"
    :key="key"
    class="showLinks my-3"
    :id="`category_${index + 1}`"
  >
    <h3 class="text-center">{{ key }}</h3>
    <template v-if="intertexts[0].supercategory">
      <div
        v-for="[k, subIntertexts] in groupBySubcategory(intertexts)"
        :key="k"
        class="my-3"
      >
        <h4 class="text-center">{{ k }}</h4>
        <IntertextListing
          v-for="i in subIntertexts"
          :key="i.id"
          :intertext="i"
        />
      </div>
    </template>

    <template v-else>
      <IntertextListing v-for="i in intertexts" :key="i.id" :intertext="i" />
    </template>
    <BackToTop />
  </ArticleContainer>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { groupBy, IntertextShort } from '@/interfaces/IntertextShort';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import BackToTop from '@/components/intertext/BackToTop.vue';
import IntertextListing from '@/components/intertext/IntertextListing.vue';

export default defineComponent({
  props: { byCategory: Object as PropType<Map<string, IntertextShort[]>> },
  components: { ArticleContainer, BackToTop, IntertextListing },
  setup() {
    function groupBySubcategory(
      intertexts: IntertextShort[],
    ): Map<string, IntertextShort[]> {
      return groupBy(intertexts, (i) => i.category);
    }
    return { groupBySubcategory };
  },
});
</script>
