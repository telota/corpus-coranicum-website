<template>
  <label for="manuscripts" v-if="justNavigation"
    >{{ $t('manuscripts.choose_manuscript') }}:</label
  >
  <label v-else-if="isLoaded(manuscriptVerseResults)" for="manuscripts">
    {{
      $t('manuscripts.result_count', {
        count: manuscriptVerseResults.payload.length,
        sura,
        verse,
      })
    }}
  </label>
  <label v-else for="manuscripts">&nbsp;</label>
  <select
    class="w-full bg-green-200 border"
    name="manuscripts"
    id="manuscripts"
    :value="selected"
    @change="navigate"
  >
    <option
      v-for="manuscript in manuscriptVerseResults.payload"
      :key="manuscript.manuscript_id"
      :value="manuscript.manuscript_id"
    >
      {{ manuscript.title }}
    </option>
  </select>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { useRouter } from 'vue-router';
import { manuscriptVerseResults } from '@/api/manuscripts';
import { isLoaded } from '@/interfaces/RemoteData';

export default defineComponent({
  props: {
    sura: Number,
    verse: Number,
    selected: Number,
    justNavigation: Boolean,
  },
  setup(props) {
    const router = useRouter();
    function navigate(e: any) {
      console.log('Navigating!');
      let selectedManuscript;
      if (isLoaded(manuscriptVerseResults.value)) {
        selectedManuscript = manuscriptVerseResults.value.payload.find(
          (r) => r.manuscript_id === +e.target.value,
        );
      }
      if (+e.target.value > 0 && selectedManuscript && props.selected !== +e.target.value) {
        console.log('Really navigatin!');
        router.push({
          name: 'ManuscriptPage',
          params: {
            manuscript: e.target.value,
            page: selectedManuscript.pages[0].folio + selectedManuscript.pages[0].side,
          },
          query: {
            sura: props.sura,
            verse: props.verse,
          },
        });
      }
    }
    return {
      manuscriptVerseResults,
      navigate,
      isLoaded,
    };
  },
});
</script>
