<template>
  <ArticleContainer class="infoitem">
    <h2 :id="item.id" class="text-center py-3">{{ item.title }}</h2>
    <h3 v-if="item.subtitle" class="text-center py-3">{{ item.subtitle }}</h3>
    <ImageHolder
      v-if="item.image"
      class="py-3 text-center"
      :imageUrl="publicPath + 'img/' + item.image"
      :imageCaption="item.image_caption"
      :loadingHeight="100"
    />
    <div v-if="item.html" v-html="item.html" class="htmlContent showLinks" />
    <ul v-if="item.bullets" class="list-disc py-3 pl-8">
      <li v-for="b in item.bullets" :key="b">{{ b }}</li>
    </ul>
    <p v-for="(p, index) in item.paragraphs" :key="index" v-html="p"/>
    <h3 v-if="item.links">Links</h3>
    <ul v-if="item.links" class="pb-3 showLinks">
      <li v-for="l in item.links" :key="l.url">
        <a
            :href="
              l.add_language
                ? `/${$i18n.locale}${l.url}`
                : l.url
            "
          >
          {{ l.text }}
          </a>
      </li>
    </ul>
  </ArticleContainer>
</template>
<script lang="ts">
import { defineComponent, onMounted, PropType } from 'vue';
import { useRoute } from 'vue-router';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import { InfoItem } from '@/interfaces/InfoItem';
import ImageHolder from '../global/ImageHolder.vue';
import scrollToHash from '../global/scrollToHash';

export default defineComponent({
  components: {
    ArticleContainer,
    ImageHolder,
  },
  props: { item: Object as PropType<InfoItem> },
  setup() {
    const publicPath = process.env.BASE_URL;
    const route = useRoute();
    onMounted(() => {
      scrollToHash(route);
    });
    return { publicPath };
  },
});
</script>
