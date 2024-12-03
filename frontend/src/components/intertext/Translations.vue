<template>
  <ScrollCard
    v-for="(t, language) in toDisplay"
    :key="language"
    :title="$t('intertext.translation', { language })"
    :htmlContent="t"
    :informationText="germanSource"
  />
</template>
<script lang="ts">
import { computed, defineComponent, PropType } from 'vue';
import { Translations } from '@/interfaces/Translations';
import ScrollCard from '../global/ScrollCard.vue';

export default defineComponent({
  components: { ScrollCard },
  props: {
    translations: Object as PropType<Translations>,
    germanSource: String,
  },
  setup(props) {
    const toDisplay = computed(() => {
      const translations: { [key: string]: string } = {};
      if (props.translations) {
        Object.entries(props.translations).forEach((entry) => {
          const [key, value] = entry;
          if (value) {
            translations[key] = value;
          }
        });
      }
      return translations;
    });
    return { toDisplay };
  },
});
</script>
