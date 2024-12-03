<template>
  <div>
    <h2 class="text-center" id="catalogue_entry">
      {{ $t('manuscripts.catalogue_entry') }}
    </h2>
    <ArticleContainer class="mt-3 mb-6 showLinks">
      <h2>{{ manuscriptTitle(manuscript) }}</h2>
      <ArticleSection>
        <h3>{{ $t('manuscripts.editors') }}</h3>
        <p class="pt-4">{{ manuscript.editors ? manuscript.editors : manuscript?.citation }}</p>
      </ArticleSection>
      <ArticleSection>
        <!-- <h3>{{ $t('manuscripts.commentary') }}</h3> -->
        <div v-html="manuscript.commentary || manuscript.catalogue_entry" class="pt-4 showLinks" />
      </ArticleSection>
      <ArticleSection v-if="manuscript.codicology">
        <h3>{{ $t('manuscripts.codicology') }}</h3>
        <div class="pt-4" v-html="manuscript.codicology" />
      </ArticleSection>
      <ArticleSection v-if="manuscript.paleography">
        <h3>{{ $t('manuscripts.palaeography') }}</h3>
        <div class="pt-4" v-html="manuscript.paleography" />
      </ArticleSection>
      <ArticleSection v-if="manuscript.literature">
        <h3>{{ $t('manuscripts.literature') }}</h3>
        <div v-html="manuscript.literature" class="pt-4 showLinks" />
      </ArticleSection>
      <ArticleSection v-if="manuscript.bibliography">
        <h3>{{ $t('manuscripts.literature') }}</h3>
        <ul class="pt-4 showLinks list-disc mx-7">
          <li v-for="(entry, index) in manuscript.bibliography" :key="index">
            <a
              :href="`${entry.zotero_key}`"
              target="_blank"
              rel="noopener noreferrer"
              >{{ entry.citation }}</a
            >
          </li>
        </ul>
      </ArticleSection>
    </ArticleContainer>
  </div>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { ManuscriptDetail, manuscriptTitle } from '@/interfaces/ManuscriptDetail';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import ArticleSection from '@/components/global/ArticleSection.vue';

export default defineComponent({
  methods: { manuscriptTitle },
  components: {
    ArticleContainer,
    ArticleSection,
  },
  props: {
    manuscript: {
      type: Object as PropType<ManuscriptDetail>,
      required: true,
    },
  },
  setup() {
    return {};
  },
});
</script>
