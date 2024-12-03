<template>
  <div
    v-if="typeof images === 'string' || images.length === 0"
    class="
      h-96
      text-center
      flex flex-col
      justify-center
      px-2
      my-3
      max-w-screen-md
      w-full
      mx-auto
      bg-white
    "
  >
    <h3 v-if="typeof images === 'string'">{{ $t('global.image_not_allowed') }}</h3>
    <h3 v-else>{{ $t('global.no_image_available') }}</h3>
  </div>
  <OpenSeaDragonViewer
    v-else
    :image_links="images.map((i) => i.external_url)"
    :iiifJsonUrls="images.map((i) => i.iiif_url)"
    :image_sources="images.map((i) => i.image_source)"
  />
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { MaybeImages } from '@/interfaces/ImageNotAllowed';
import OpenSeaDragonViewer from '@/components/global/OpenSeaDragonViewer.vue';

export default defineComponent({
  components: { OpenSeaDragonViewer },
  props: { images: [Object, String] as PropType<MaybeImages> },
});
</script>
