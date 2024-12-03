<template>
  <ArticleContainer class="py-3 my-3" :id="`archive_${archive.id}`">
    <h4 class="showLinks" v-if="archive.link">
      <a :href="archive.link" target="_blank">
        {{ archiveName }}
      </a>
    </h4>
    <h4 v-else>
      {{ archiveName }}
    </h4>
    <div>
      <ImageHolder
        class="h-52 float-left pr-4 pt-2 pb-4"
        v-if="archive.image"
        :imageUrl="publicPath + 'img/' + archive.image"
        :imageCaption="archive.image_description"
        :imageCaptionLink="archive.image_link"
      />
      <p class="min-h-52 showLinks" v-html="archive.description" />
    </div>
    <div class="pt-6 showLinks">
      <h4>{{ $t('manuscripts.list_of_manuscripts') }}</h4>
      <router-link v-for="m in archive.manuscripts" :key="m.id" :to="manuscriptLink(m)">
        <p>{{ m.title }}</p>
      </router-link>
    </div>
  </ArticleContainer>
</template>
<script lang="ts">
import { computed, defineComponent, PropType } from 'vue';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import ImageHolder from '@/components/global/ImageHolder.vue';
import { ArchiveDetail } from '@/interfaces/ArchiveDetail';
import { RouteLocationRaw } from 'vue-router';
import { ManuscriptShort } from '@/interfaces/ManuscriptShort';

export default defineComponent({
  props: { archive: Object as PropType<ArchiveDetail> },
  components: {
    ArticleContainer,
    ImageHolder,
  },
  setup(props) {
    const publicPath = process.env.BASE_URL;
    const archiveName = computed(() => {
      if (props.archive) {
        return `${props.archive.name} (${props.archive.city}, ${props.archive.country_code})`;
      }
      return '';
    });

    function manuscriptLink(m: ManuscriptShort): RouteLocationRaw {
      const sura = m.sura ? m.sura : 1;
      const verse = m.verse > 0 ? m.verse : 1;
      let query;
      if (m.sura > 0 && m.verse > 0) {
        query = {
          sura,
          verse,
        };
      }

      if (m.page) {
        return {
          name: 'ManuscriptPage',
          params: {
            manuscript: m.id,
            page: m.page,
          },
          query,
        };
      }

      return {
        name: 'ManuscriptSingle',
        params: { manuscript: m.id },
      };
    }

    return {
      publicPath,
      archiveName,
      manuscriptLink,
    };
  },
});
</script>
