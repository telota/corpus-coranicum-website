<template>
  <div class="howtoquote p-4 my-4 bg-white">
  <p class="text-xl">
    {{ $t('global.how_to_cite') }}
  </p>
  <p class="py-2 text-xl">
    {{ precitation ? precitation + mainCitation : mainCitation }}
  </p>
</div>
</template>
<script lang="ts">
import { computed, defineComponent } from 'vue';

export default defineComponent({
  props: {
    citation: String, precitation: String,
  },
  setup(props) {
    const mainCitation = computed(() => {
      if (props.citation) {
        const date = new Date(Date.now());
        const formatted = `${date.getDate()}.${date.getMonth() + 1}.${date.getFullYear()}`;
        return props.citation.replace('%DATE%', formatted);
      }
      return '';
    });
    return { mainCitation };
  },
});
</script>
