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

    const fields = computed(() => [
      [t('global.source'), props.intertext?.source],
      [t('intertext.identified_by'), props.intertext?.identified_by],
    ]);

    return { fields };
  },
});
</script>
