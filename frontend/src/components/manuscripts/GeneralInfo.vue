<template>
  <div class="overflow-x-auto border showLinks p-2 my-4">
    <table class="table-auto">
      <tbody>
        <tr v-for="f in tableFields" :key="f[0]" class="">
          <td class="align-top">{{ `${f[0]}:` }}</td>
          <td class="whitespace-normal align-top pl-2" v-if="f.length == 2">
            {{ f[1] }}
          </td>
          <td class="whitespace-normal pl-2" v-else-if="f.length === 3">
            <a :href="f[2]">{{ f[1] }}</a>
          </td>
        </tr>
      </tbody>
    </table>

    <p class="pt-4">
      {{
        `${$t('manuscripts.editors')}: ${
          'citation' in manuscript ? manuscript.citation : manuscript.editors
        }`
      }}
    </p>
  </div>
</template>
<script lang='ts'>
import { computed, defineComponent, PropType } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';
import { ManuscriptDetail } from '@/interfaces/ManuscriptDetail';
import { toText } from '@/interfaces/ManuscriptPassage';

export default defineComponent({
  props: { manuscript: Object as PropType<ManuscriptDetail> },
  setup(props) {
    const router = useRouter();
    const route = useRoute();
    const { t } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const archive = computed(
      () => `${props.manuscript?.archive.name} (${props.manuscript?.archive.city})`,
    );
    const archiveFields = computed(() => {
      const fields = [t('manuscripts.archive'), archive.value];
      if (props.manuscript?.archive.id) {
        const url = router.resolve({
          path: `/${route.params.lang}/manuscripts`,
          hash: `#archive_${props.manuscript.archive.id}`,
        }).href;
        fields.push(url);
      }
      return fields;
    });

    const lineCount = computed(() => {
      if (props.manuscript?.line_count) {
        return props.manuscript.line_count;
      }

      if (props.manuscript?.line_min === props.manuscript?.line_max) {
        return props.manuscript?.line_min;
      }

      return `Minimum: ${props.manuscript?.line_min}, Maximum: ${props.manuscript?.line_max}`;
    });

    const tableFields = computed(() => {
      if (props.manuscript) {
        // Check if it's the new manuscript structure
        if (
          !('title' in props.manuscript)
          && props.manuscript.provenances
          && props.manuscript.script_styles
        ) {
          let carbon_dating = '';
          if (props.manuscript.carbon_dating) {
            carbon_dating = `${props.manuscript?.carbon_dating} BP (before present)`;
          }
          return [
            archiveFields.value,
            [t('manuscripts.call_number'), props.manuscript.call_number],
            [
              t('manuscripts.quantity'),
              `${t('fe.manuscripts.folios', { count: props.manuscript.number_of_folios || 0 })}`,
            ],
            [t('manuscripts.format'), props.manuscript.dimensions],
            ['Text area dimensions', props.manuscript.format_text_field],
            [t('manuscripts.provenance'), props.manuscript.provenances.join(', ')],
            [t('manuscripts.date'), props.manuscript.date],
            [t('manuscripts.material'), props.manuscript.writing_surface],
            ['Carbon Dating', carbon_dating],
            [t('manuscripts.writing_style'), props.manuscript.script_styles.join(', ')],
            [t('manuscripts.line_count'), lineCount.value],
            [
              t('manuscripts.quran_passages'),
              props.manuscript.passages.map((p) => toText(p)).join(', '),
            ],
          ];
        }

        return [
          archiveFields.value,
          [t('manuscripts.call_number'), props.manuscript.call_number],
          [t('manuscripts.quantity'), props.manuscript.extent],
          [t('manuscripts.format'), props.manuscript.format],
          [t('manuscripts.provenance'), props.manuscript.provenance],
          [t('manuscripts.date'), props.manuscript.date],
          [t('manuscripts.material'), props.manuscript.material_kind],
          [
            t('manuscripts.writing_style'),
            props.manuscript.writing_style?.replaceAll(new RegExp('<[^>]*>', 'g'), ''),
          ],
          [t('manuscripts.line_count'), props.manuscript.line_count],
          [
            t('manuscripts.quran_passages'),
            props.manuscript.passages.map((p) => toText(p)).join(', '),
          ],
        ];
      }
      return [];
    });
    return { tableFields };
  },
});
</script>
