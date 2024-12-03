<template>
  <table
    class="table-auto border-separate"
    :style="{
      'border-spacing': 0,
    }"
  >
    <thead class="border-b">
      <tr>
        <th class="border-r bg-clip-padding bg-white lg:sticky left-0"></th>
        <th
          class="border-r bg-clip-padding bg-white lg:sticky"
          :style="{ left: offsetWidth + 'px' }"
        ></th>
        <th colspan="128" class="text-left bg-white">
          {{ `${$t('variants.words')} 1-${Object.keys(variants.reference).length}` }}
        </th>
      </tr>
      <tr>
        <th class="border-r bg-clip-padding bg-white lg:sticky left-0" ref="firstCol">
          {{ $t('variants.work') }}
        </th>
        <th
          class="border-r bg-clip-padding bg-white lg:sticky"
          :style="{ left: offsetWidth + 'px' }"
        >
          {{ $t('variants.reader') }}
        </th>
        <th
          v-for="(value, key) in variants.reference"
          :key="key"
          :id="'word-column-' + key"
          class="bg-white text-center"
        >
          {{ key }}
        </th>
      </tr>
    </thead>
    <tbody ref="tableBody">
      <VariantsRow
        v-for="(v, index) in displayRows"
        :verseCount="Object.keys(variants.reference).length"
        :key="v.reading_id"
        :variant="v"
        :odd="index % 2 === 1"
        :freezeWidth="offsetWidth"
      />
    </tbody>
  </table>
</template>
<script lang="ts">
import { ComponentPublicInstance, computed, defineComponent, PropType, ref, watch } from 'vue';
import { VariantsCanonical } from '@/interfaces/VariantsCanonical';
import { VariantsReader } from '@/interfaces/VariantsReader';
import { VariantsReading } from '@/interfaces/VariantsReading';
import { VariantsVerse } from '@/interfaces/VariantsVerse';
import VariantsRow from '@/components/variants/VariantsRow.vue';
import { indexRows } from '@/components/variants/filterFunctions';

export default defineComponent({
  props: {
    variants: Object as PropType<VariantsVerse>,
    canonical: Object as PropType<VariantsCanonical>,
    searchTerm: String,
  },
  components: { VariantsRow },
  setup(props) {
    const firstCol = ref<ComponentPublicInstance<HTMLElement>>();
    const tableBody = ref<ComponentPublicInstance<HTMLElement>>();
    const offsetWidth = ref(0);

    function setOffsetWidth() {
      if (firstCol.value) {
        if (firstCol.value.clientWidth % 2 === 0) {
          offsetWidth.value = firstCol.value.clientWidth + 0.5;
        } else {
          offsetWidth.value = firstCol.value.clientWidth + 1;
        }
      }
    }

    const observer = new MutationObserver(() => {
      setOffsetWidth();
    });

    watch(firstCol, () => {
      setOffsetWidth();
      if (tableBody.value) {
        observer.observe(tableBody.value, {
          attributes: false,
          childList: true,
          subtree: false,
        });
      }
    });

    function yearToNumb(year: string): number {
      const cleaned = year.replace('ca.', '');
      return +cleaned;
    }

    function removeExhaustedTeacherOrStudents(readers: VariantsReader[]): VariantsReader[] {
      const cleaned: VariantsReader[] = [];
      for (let i = 1; i <= 7; i += 1) {
        const filtered = readers.filter((r) => Math.floor(+r.sigle / 100) === i);
        const justTeacher = filtered.filter((r) => +r.sigle % 100 === 0);
        if (filtered.length === 3) {
          cleaned.push(...justTeacher);
        } else if (justTeacher.length > 0 && filtered.length === 2) {
          cleaned.push(...filtered);
        }
      }
      return cleaned;
    }

    function distributeReaders(canon: VariantsReading, canonVariants: VariantsReading[]): void {
      const allVariantReaders = canonVariants.flatMap((v) => v.readers);
      const filteredCanon = canon.readers.filter(
        (r) => !allVariantReaders.find((v) => v.sigle === r.sigle),
      );

      canonVariants.forEach((variant) => {
        const teachers: VariantsReader[] = [];
        variant.readers.forEach((r) => {
          // If student is in a variant, add the teacher as well
          if (+r.sigle % 100 > 0) {
            const teacherSigle = r.sigle.replace(/.$/, '0');
            const teacher = canon.readers.find((cr) => cr.sigle === teacherSigle);
            if (teacher) {
              teachers.push(teacher);
            }
          }
        });

        variant.readers.push(...teachers);
        variant.readers.sort((a, b) => (+a.sigle < +b.sigle ? -1 : 1));
      });
      canon.readers = removeExhaustedTeacherOrStudents(filteredCanon);
    }

    const displayTable = computed(() => {
      if (props.canonical && props.variants) {
        const standardVerse: { [key: number]: string } = {};
        Object.entries(props.variants.reference).forEach(([key, value]) => {
          standardVerse[+key] = value.transcription;
        });

        const standard: VariantsReading = JSON.parse(
          JSON.stringify({
            reading_id: -1,
            work: props.canonical.work,
            readers: props.canonical.readers,
            variants: standardVerse,
          }),
        );
        const table: VariantsReading[] = JSON.parse(
          JSON.stringify(props.variants.variant_readings),
        );
        table.push(standard);
        table.sort((a, b) => {
          if (yearToNumb(a.work.death_year) > yearToNumb(b.work.death_year)) {
            return 1;
          }
          if (yearToNumb(a.work.death_year) === yearToNumb(b.work.death_year)) {
            if (a.work.display_name > b.work.display_name) {
              return -1;
            }
            return 1;
          }
          return -1;
        });

        const canonVariants = table.filter((v) => v.work.canonical === 1 && v.reading_id > 0);
        distributeReaders(standard, canonVariants);
        return table;
      }

      return [];
    });

    const indexedRows = computed(() => indexRows(displayTable.value));

    const displayRows = computed(() => {
      if (props.searchTerm) {
        const searchTerms = props.searchTerm.split(' ');
        return displayTable.value.filter((row) => {
          if (row.reading_id === -1) {
            return true;
          }
          const searchString = indexedRows.value.get(row.reading_id);
          if (searchString) {
            return searchTerms.some((term) => {
              if (!term) {
                return false;
              }
              const regex = new RegExp(`.*${term}.*`, 'gi');
              return regex.test(searchString);
            });
          }
          return false;
        });
      }
      return displayTable.value;
    });

    return {
      displayTable,
      firstCol,
      tableBody,
      offsetWidth,
      indexedRows,
      displayRows,
    };
  },
});
</script>
