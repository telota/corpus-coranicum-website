<template>
  <SimpleCard class="w-full block mx-auto">
    <h3>{{ ('title' in manuscript) ?
      manuscript.title :
      manuscript.archive.name + ': ' + manuscript.call_number
      }}</h3>
    <GeneralInfo :manuscript="manuscript" />
    <div class="flex flex-wrap items-center">
      <PageSelect :pages="manuscript.pages" class="flex-grow min-width-0" />
      <a href="#catalogue_entry" class="py-2">
        <PrimaryButton class="max-w-full w-72">{{
          $t('manuscripts.to_catalogue_entry')
        }}</PrimaryButton>
      </a>
    </div>
  </SimpleCard>
</template>
<script lang="ts">
import { defineComponent, PropType } from 'vue';
import { ManuscriptDetail } from '@/interfaces/ManuscriptDetail';
import SimpleCard from '@/components/global/SimpleCard.vue';
import GeneralInfo from '@/components/manuscripts/GeneralInfo.vue';
import PageSelect from './PageSelect.vue';
import PrimaryButton from '../global/PrimaryButton.vue';

export default defineComponent({
  components: {
    SimpleCard, GeneralInfo, PageSelect, PrimaryButton,
  },
  props: { manuscript: Object as PropType<ManuscriptDetail> },
  setup() {
    return {};
  },
});
</script>
