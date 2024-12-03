<template>
  <ArticleContainer class="showLinks">
    <div class="flex flex-row">
    <h2 id="text">Text</h2>
    <MoreInfo
      v-if="t('commentary.text_infotext')"
      :showInfo="showInfo"
      :infoText="t('commentary.text_infotext')"
      @click="showInfo = !showInfo"
      class="ml-4"
    />
    </div>
    <div
          :class="showInfo ? 'max-h-large' : 'max-h-0'"
          class="text-m overflow-hidden transition transition-maxHeight ease-in-out duration-700"
        >
          <div class="bg-grey-verylight px-3 py-5 mt-7" v-html="t('commentary.text_infotext')" />
        </div>
    <table>
      <CommentaryLine
        v-for="(line, index) in commentary.text_structure"
        :key="line"
        :line="line"
        :previous="index > 0 ? commentary.text_structure[index - 1] : undefined"
      />
    </table>
    <BackToTop />
  </ArticleContainer>
  <div v-for="section in commentary.sections" :key="section.id" class="showLinks">
    <template v-if="section.heading">
      <h2 class="text-center pt-6" :id="section.id">{{ section.heading }}</h2>
      <CommentarySection
        v-for="subSection in section.sections"
        :key="subSection.ud"
        class="showLinks my-3"
        :id="subSection.id"
        :section="subSection"
      />
    </template>
    <CommentarySection v-else class="showLinks my-3" :id="section.id" :section="section" />
  </div>
</template>
<script lang="ts">
import { defineComponent, onMounted, onUpdated, PropType, ref } from 'vue';
import { connectQuranRefsToPopper } from '@/components/commentary/popper';
import { createLinks } from '@/components/commentary/linker';
import { Commentary } from '@/interfaces/Commentary';
import CommentarySection from '@/components/commentary/CommentarySection.vue';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import CommentaryLine from '@/components/commentary/CommentaryLine.vue';
import { useRoute, useRouter } from 'vue-router';
import routeParamToString from '@/router/param_as_string';
import scrollToHash from '@/components/global/scrollToHash';
import { useI18n } from 'vue-i18n';
import MoreInfo from '@/components/global/MoreInfo.vue';
import BackToTop from '../intertext/BackToTop.vue';

export default defineComponent({
  components: {
    BackToTop,
    CommentarySection,
    ArticleContainer,
    CommentaryLine,
    MoreInfo,
  },
  props: {
    commentary: Object as PropType<Commentary>,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });

    console.log('Übersetzungswert:', t('commentary.text_infotext')); // Überprüft, ob der Schlüssel existiert
    const showInfo = ref(false);
    /** Note: this setup logic is largely a duplicate
    of the CommentaryIntroduction logic. Maybe you can combine them?
    * */
    const router = useRouter();
    const route = useRoute();

    function makeLinksAndPoppers() {
      createLinks(router, route);

      // Hook up Quran references to popper.
      connectQuranRefsToPopper(routeParamToString(route.params.lang));
    }

    onMounted(() => {
      scrollToHash(route);

      makeLinksAndPoppers();
    });

    onUpdated(() => {
      makeLinksAndPoppers();
    });
    return {
      t,
      showInfo,
    };
  },
});
</script>
