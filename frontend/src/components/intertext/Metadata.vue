<template>
  <Card :title="$t('intertext.metadata')">
    <div class="p-3">
      <GeneralInfoTable :fields="fields" />
    </div>
  </Card>
</template>
<script lang="ts">
import { computed, defineComponent } from 'vue';
import { useI18n } from 'vue-i18n';
import { useRoute } from 'vue-router';
import GeneralInfoTable from '@/components/global/GeneralInfoTable.vue';
import Card from '@/components/global/Card.vue';
import { intertextDetail } from '@/api/intertext';
import { isLoaded } from '@/interfaces/RemoteData';
import { makeCategory } from '@/interfaces/IntertextDetail';

export default defineComponent({
  components: {
    Card,
    GeneralInfoTable,
  },
  setup() {
    const route = useRoute();

    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });

    const updatedDate = computed(() => {
      if (isLoaded(intertextDetail.value)) {
        const date = new Date(intertextDetail.value.payload.updated_at);
        return `${date.getDate()}.${date.getMonth() + 1}.${date.getFullYear()}`;
      }
      return '';
    });

    const category = computed(() => {
      if (isLoaded(intertextDetail.value)) {
        return makeCategory(intertextDetail.value.payload);
      }
      return '';
    });

    const fields = computed(() => {
      if (isLoaded(intertextDetail.value)) {
        const theFields = [
          [t('intertext.tuk_number'), route.params.id],
          [t('intertext.category'), category.value],
          [t('intertext.last_updated'), updatedDate.value],
        ];
        if (intertextDetail.value.payload.first_published) {
          theFields.splice(2, 0, [
            t('intertext.first_published_on'),
            intertextDetail.value.payload.first_published,
          ]);
        }
        return theFields;
      }
      return [];
    });

    return { fields };
  },
});
</script>
