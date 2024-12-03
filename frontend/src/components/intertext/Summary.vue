<template>
  <router-link
    class="block max-w-screen-md mx-auto my-5"
    :to="{
      name: 'VerseIntertextDetail',
      params: { id: intertext.id },
    }"
  >
    <SimpleCard>
      <h3>{{ intertext.title }}</h3>
      <h4>{{ $t('intertext.editor') }}: {{ intertext.entry_author }}</h4>
      <GeneralInfoTable :fields="tableFields" />
    </SimpleCard>
  </router-link>
</template>
<script lang="ts">
import { computed, defineComponent, PropType } from 'vue';
import { useI18n } from 'vue-i18n';
import { IntertextSummary } from '@/interfaces/IntertextSummary';
import GeneralInfoTable from '@/components/global/GeneralInfoTable.vue';
import SimpleCard from '@/components/global/SimpleCard.vue';
import { makeCategory } from '@/interfaces/IntertextDetail';

export default defineComponent({
  components: {
    SimpleCard,
    GeneralInfoTable,
  },
  props: { intertext: Object as PropType<IntertextSummary> },
  setup(props) {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const tableFields = computed(() => {
      if (props.intertext) {
        return [
          [t('intertext.tuk_number'), props.intertext.id],
          [t('intertext.original_language'), props.intertext.language],
          [t('global.location'), props.intertext.location],
          [t('global.date'), props.intertext.dated],
          [t('intertext.category'), makeCategory(props.intertext)],
        ];
      }
      return [[]];
    });

    return { tableFields };
  },
});
</script>
