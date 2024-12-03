<template>
  <ArticleContainer :id="section.id" class="showTable">
    <!-- <h2>
      <span v-html="section.general_title" />
      <span v-if="section.general_title && section.specific_title">: </span>
      <span v-html="section.specific_title" />
    </h2> -->
    <div>
      <div>
        <div class="flex flex-row">
          <h2 class="text-black">
            <span v-html="section.general_title" />
            <span v-if="section.general_title && section.specific_title">: </span>
            <span v-html="section.specific_title" />
          </h2>

          <MoreInfo
            v-if="section.comment_title"
            :showInfo="showInfo"
            @click="showInfo = !showInfo"
            class="ml-4"
          />
        </div>
        <div
          :class="showInfo ? 'max-h-large' : 'max-h-0'"
          class="text-m overflow-hidden transition transition-maxHeight ease-in-out duration-700"
        >
          <div class="bg-grey-verylight px-3 py-5 mt-7" v-html="section.comment_title" />
        </div>
      </div>
    </div>
    <br />
    <div v-if="section.content" v-html="section.content" class="pb-6" />
    <template v-if="section.verse_content">
      <CommentaryVerses
        v-for="comment in section.verse_content"
        :key="comment.content"
        :commentary="comment"
        :sectionId="section.id"
      />
    </template>
    <div v-if="section.works_cited">
      <h3 class="pb-2">Literaturliste</h3>
      <div v-html="section.works_cited" />
    </div>
    <BackToTop />
  </ArticleContainer>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
// Stelle sicher, dass der Import von MoreInfo vor ArticleContainer erfolgt
import MoreInfo from '@/components/global/MoreInfo.vue';
import { CommentarySection } from '@/interfaces/CommentarySection';
import ArticleContainer from '../global/ArticleContainer.vue';
import CommentaryVerses from './CommentaryVerses.vue';
import BackToTop from '../intertext/BackToTop.vue';

export default defineComponent({
  components: {
    MoreInfo,
    ArticleContainer,
    CommentaryVerses,
    BackToTop,
  },
  props: {
    section: Object as PropType<CommentarySection>,
  },
  data() {
    return {
      showInfo: false,
    };
  },
});
</script>
