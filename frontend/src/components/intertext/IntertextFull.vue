<template>
  <Article :intertext="intertext" :precitation="precitation" />
  <Materials :intertext="intertext" />
  <References />
  <HowToQuote
    v-if="isLoaded(intertextWeb)"
    :citation="intertextWeb.payload.how_to_cite"
    :precitation="precitation"
  />
</template>
<script lang="ts">
import { computed, defineComponent, PropType } from 'vue';
import References from '@/components/intertext/References.vue';
import Materials from '@/components/intertext/Materials.vue';
import Article from '@/components/intertext/Article.vue';
import { IntertextDetail } from '@/interfaces/IntertextDetail';
import { intertextWeb } from '@/api/web';
import { isLoaded } from '@/interfaces/RemoteData';
import HowToQuote from '../global/HowToQuote.vue';

export default defineComponent({
  components: {
    Article,
    Materials,
    References,
    HowToQuote,
  },
  props: { intertext: Object as PropType<IntertextDetail> },
  setup(props) {
    const precitation = computed(() => {
      if (props.intertext) {
        return props.intertext.entry_author.concat(
          ', ',
          props.intertext.title,
          ' - TUK_',
          String(props.intertext.id),
          '. In: ',
        );
      }
      return '';
    });
    return {
      intertextWeb,
      precitation,
      isLoaded,
    };
  },
});
</script>
