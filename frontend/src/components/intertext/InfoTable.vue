<template>
  <GeneralInfoTable :fields="fields" />
</template>
<script lang="ts">
import { computed, defineComponent, PropType } from 'vue';
import { useI18n } from 'vue-i18n';
import { IntertextDetail } from '@/interfaces/IntertextDetail';
import GeneralInfoTable from '@/components/global/GeneralInfoTable.vue';

export default defineComponent({
  props: { intertext: Object as PropType<IntertextDetail> },
  components: { GeneralInfoTable },
  setup(props) {
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });

    const fields = computed(() => {
      if (props.intertext) {
        const theFields = [
          [t('intertext.original_language'), props.intertext.language],
          [t('global.location'), props.intertext.location],
          [t('global.date'), props.intertext.dated],
        ];
        if (props.intertext.intertext_author) {
          theFields.push([t('intertext.author'), props.intertext.intertext_author]);
        }
        return theFields;
      }
      return [];
    });

    return { fields };
  },
});
</script>
