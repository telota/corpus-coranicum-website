<template>
  <figure class="max-w-7xl mx-auto">
    <div ref="openseadragontoolbar" class="mt-1">
      <div
        v-show="iiifJsonUrls.length > 1"
        class="inline-block w-full xl:w-1/3 xl:text-left text-right h-10"
      >
        <ArrowIcon type="back" :width="16" class="black inline h-12" />
        <button class="underline" id="next">
          {{ $t('navigation.next') }}
        </button>
        |
        <button class="underline" id="previous">
          {{ $t('navigation.previous') }}
        </button>
        <ArrowIcon type="forward" :width="12" class="inline h-12" />
        {{
          $t('navigation.progress', {
            current: currentImage + 1,
            total: iiifJsonUrls.length,
          })
        }}
      </div>
      <div
        class="w-full h-10 text-right inline-block"
        :class="iiifJsonUrls.length > 1 ? 'xl:w-2/3' : ''"
      >
        <SmallButton class="bg-green-200 mx-1" id="zoom-in">
          {{ $t('navigation.zoom_in') }}
        </SmallButton>
        <SmallButton class="bg-green-200 mx-1" id="zoom-out">
          {{ $t('navigation.zoom_out') }}
        </SmallButton>
        <SmallButton class="bg-green-200 mx-1" id="full-page">
          {{ $t('navigation.fullscreen') }}
        </SmallButton>
        <SmallButton class="bg-green-200 mx-1" id="home">
          {{ $t('navigation.reset') }}
        </SmallButton>
      </div>
    </div>
    <div ref="openseadragon" id="openseadragon" class="bg-grey-dark h-80 md:h-800" />
    <FigureCaption
      :imageCaption="image_sources[currentImage]"
      :imageCaptionLink="image_links[currentImage]"
      :largeCaption="true"
    />
  </figure>
</template>
<script lang="ts">
import { computed, defineComponent, onMounted, PropType, ref, Ref, watch } from 'vue';
import OpenSeadragon from 'openseadragon';
import { OpenSeadragonOptions } from '@/interfaces/OpenSeaDragonOptions';
import SmallButton from '@/components/global/SmallButton.vue';
import ArrowIcon from '@/components/icons/ArrowIcon.vue';
import FigureCaption from '@/components/global/FigureCaption.vue';
import { useI18n } from 'vue-i18n';

export default defineComponent({
  components: {
    ArrowIcon,
    SmallButton,
    FigureCaption,
  },
  props: {
    iiifJsonUrls: Array as PropType<Array<string>>,
    image_sources: Array as PropType<Array<string>>,
    image_links: Array as PropType<Array<string>>,
  },
  setup(props) {
    const currentImage: Ref<number> = ref(0);
    let viewer;
    const openseadragon: Ref<HTMLElement | null> = ref(null);
    const openseadragontoolbar: Ref<HTMLElement | null> = ref(null);
    const {
      t, locale,
    } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });

    const previousImage = computed(() => t('navigation.previous_image'));
    const nextImage = computed(() => t('navigation.next_image'));
    function setOpenSeadragonTooltips() {
      OpenSeadragon.setString('Tooltips.PreviousPage', previousImage.value);
      OpenSeadragon.setString('Tooltips.NextPage', nextImage.value);
    }

    watch(locale, () => {
      setOpenSeadragonTooltips();
    });

    onMounted(() => {
      OpenSeadragon.setString('Tooltips.Home', '');
      OpenSeadragon.setString('Tooltips.ZoomOut', '');
      OpenSeadragon.setString('Tooltips.ZoomIn', '');
      OpenSeadragon.setString('Tooltips.FullPage', '');
      setOpenSeadragonTooltips();

      if (props.iiifJsonUrls !== undefined) {
        viewer = OpenSeadragon({
          element: openseadragon.value,
          toolbar: openseadragontoolbar.value,
          zoomInButton: 'zoom-in',
          zoomOutButton: 'zoom-out',
          homeButton: 'home',
          fullPageButton: 'full-page',
          nextButton: 'next',
          previousButton: 'previous',
          sequenceMode: true,
          tileSources: props.iiifJsonUrls,
          showReferenceStrip: props.iiifJsonUrls.length > 1,
          referenceStripScroll: 'horizontal',
        } as OpenSeadragonOptions);

        viewer.addHandler('page', (data) => {
          currentImage.value = data.page;
        });
      }
    });

    watch(
      () => props.iiifJsonUrls,
      (iiifJsonUrls, previous) => {
        if (viewer && previous && JSON.stringify(iiifJsonUrls) !== JSON.stringify(previous)) {
          viewer.open(iiifJsonUrls);
        }
      },
    );

    return {
      currentImage,
      openseadragon,
      openseadragontoolbar,
    };
  },
});
</script>
