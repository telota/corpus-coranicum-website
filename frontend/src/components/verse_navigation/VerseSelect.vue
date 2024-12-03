<template>
  <div class="flex flex-wrap sm:flex-nowrap justify-end items-center text-black">
    <div class="flex my-2">
      <label class="font-bold" for="chapter">{{ $t('navigation.sura') }}</label>
      <select
        class="w-48 mx-2 bg-grey-light text-black"
        name="chapter"
        id="chapter"
        :value="selectedChapter"
        @change="setSuraAndResetVerse"
      >
        <option v-for="chapter in chapters.payload" :key="chapter.key" :value="chapter.key">
          {{ chapter.key + ' ' + ' ' + chapter.nameTranslit }}
        </option>
      </select>
    </div>
    <div class="flex ml-2 my-2">
      <label class="inline-block font-bold" for="verse">{{ $t('navigation.verse') }}</label>
      <select
        class="w-14 mx-2 bg-grey-light text-black"
        name="verse"
        id="verse"
        v-model="selectedVerse"
        @change="navigate"
      >
        <option v-for="n of verses" :key="n" :value="n">{{ n }}</option>
      </select>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent, ref, computed, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { isLoaded } from '@/interfaces/RemoteData';
import { getChapters, chapters } from '@/api/chapters';
import { determineVerse } from '@/router/route_to_verse';

export default defineComponent({
  setup() {
    getChapters();
    const selectedChapter = ref<number>(0);
    const selectedVerse = ref<number>(0);

    const route = useRoute();
    const router = useRouter();

    const verse = determineVerse(route);
    selectedChapter.value = verse.sura;
    selectedVerse.value = verse.verse;

    watch(
      [
        () => route.params.sura,
        () => route.params.verse,
        () => route.query.sura,
        () => route.query.verse,
      ],
      () => {
        const newVerse = determineVerse(route);
        selectedChapter.value = newVerse.sura;
        selectedVerse.value = newVerse.verse;
      },
    );

    const verses = computed(() => {
      if (isLoaded(chapters.value)) {
        const chapter = chapters.value.payload.find((c) => c.key === selectedChapter.value);
        if (chapter) {
          return chapter.verses;
        }
        return 0;
      }
      return 0;
    });

    function setSuraAndResetVerse(event: any) {
      selectedChapter.value = +event.target.value;
      selectedVerse.value = 0;
    }

    function navigate() {
      if (route.params.sura && route.params.verse) {
        router.push({
          params: {
            sura: selectedChapter.value,
            verse: selectedVerse.value,
            word: 1,
          },
        });
      } else {
        router.push({
          query: {
            sura: selectedChapter.value,
            verse: selectedVerse.value,
          },
        });
      }
    }

    return {
      chapters,
      verses,
      selectedChapter,
      selectedVerse,
      navigate,
      setSuraAndResetVerse,
    };
  },
});
</script>
