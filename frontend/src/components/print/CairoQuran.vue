<template>
  <Card
    :title="printWeb.payload?.image_description_short"
    :subtitle="pageInfo"
    :informationText="printWeb.payload?.image_description_long"
  >
    <UrlBackAndForth :imageUrl="imageUrl" @newImage="setImageUrl" />
    <OpenSeaDragonViewer
      :iiifJsonUrls="[imageUrl]"
      :image_links="[null]"
      :image_sources="[null]"
    />
  </Card>
</template>
<script lang="ts">
import { computed, defineComponent, ref, watch } from 'vue';
import Card from '@/components/global/Card.vue';
import UrlBackAndForth from '@/components/print/UrlBackAndForth.vue';
import { printData, cairoPages } from '@/api/print_edition';
import { printWeb } from '@/api/web';
import { isLoaded } from '@/interfaces/RemoteData';
import { currentPageNumber } from '@/components/print/cairo_edition_url';
import { useI18n } from 'vue-i18n';
import OpenSeaDragonViewer from '../global/OpenSeaDragonViewer.vue';

export default defineComponent({
  components: {
    Card,
    UrlBackAndForth,
    OpenSeaDragonViewer,
  },
  setup() {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const imageUrl = ref('');
    if (isLoaded(printData.value)) {
      imageUrl.value = printData.value.payload.iiif_url;
    }

    watch(printData, () => {
      if (isLoaded(printData.value)) {
        imageUrl.value = printData.value.payload.iiif_url;
      }
    });

    function setImageUrl(url: string): void {
      imageUrl.value = url;
    }

    const pageInfo = computed(() => {
      const pageNumber = currentPageNumber(imageUrl.value);
      if (isLoaded(cairoPages.value) && pageNumber) {
        const page = cairoPages.value.payload.find((p) => p.page === pageNumber);
        if (page) {
          return `${t('print_edition.page')} ${page.page}, Q ${page.range.start.sura}:${
            page.range.start.verse
          } — Q ${page.range.end.sura}:${page.range.end.verse}`;
        }
        return '&nbsp;';
      }

      return '&nbsp;';
    });

    return {
      printWeb,
      imageUrl,
      setImageUrl,
      pageInfo,
    };
  },
});
</script>
