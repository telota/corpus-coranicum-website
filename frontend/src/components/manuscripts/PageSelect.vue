<template>
  <div>
    <label class="" for="page">{{ $t('manuscripts.choose_page') }}</label>
    <select
      class="ml-2 w-full md:w-min bg-green-200 border"
      name="page"
      id="page"
      v-model="selected"
      @change="navigate"
    >
      <option :value="undefined"></option>
      <option v-for="(page, index) in pages" :key="page.page_id" :value="index">
        {{
          `${page.folio}${page.side ? page.side : ""}${
            page.passages.length === 0
              ? ''
              : ', ' + page.passages.map((p) => toText(p)).join(', ')
          }`
        }}
      </option>
    </select>
  </div>
</template>
<script lang="ts">
import { defineComponent, onMounted, PropType, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { toText } from '@/interfaces/ManuscriptPassage';
import { ManuscriptPageSummary } from '@/interfaces/ManuscriptPageSummary';

export default defineComponent({
  props: { pages: Array as PropType<Array<ManuscriptPageSummary>> },
  setup(props) {
    const route = useRoute();
    const router = useRouter();
    const selected = ref<number | undefined>(undefined);

    function setSelected() {
      if (route.params.page) {
        const index = props.pages?.findIndex((p) => route.params.page === `${p.folio}${p.side ? p.side : ''}`);
        if (index !== undefined && index >= 0) {
          selected.value = index;
        } else {
          selected.value = undefined;
        }
      }
    }

    onMounted(() => {
      setSelected();
    });

    watch(
      () => route.params.page,
      () => {
        setSelected();
      },
    );

    function navigate() {
      if (selected.value !== undefined && props.pages) {
        const page = props.pages[selected.value];
        const pageParam = page.folio + page.side;
        let params;
        let query;
        if (page.passages.length > 0) {
          const {
            sura, verse,
          } = page.passages[0].start;
          if (sura > 0 && verse > 0) {
            query = {
              sura,
              verse,
            };
            params = { page: pageParam };
          } else {
            params = { page: pageParam };
          }
        } else {
          params = { page: pageParam };
        }
        router.push({
          name: 'ManuscriptPage',
          params,
          query,
        });
      } else {
        router.push({ name: 'ManuscriptSingle' });
      }
    }

    return {
      selected,
      toText,
      navigate,
    };
  },
});
</script>
