<template>
  <tr>
    <td class="pt-2 w-1/2 arabic align-top" :class="line.insert ? 'pr-6' : ''">
      {{ line.ar }}
    </td>
    <td class="pt-2 px-2 align-top text-right whitespace-nowrap">
      {{ part }} {{ decade }} <sup>{{ verse }} </sup>
    </td>
    <td class="pt-2 w-1/2 align-top" :class="line.insert ? 'pl-6' : ''">
      {{ line.de }}
    </td>
  </tr>
</template>
<script lang="ts">
import { CommentaryLine } from '@/interfaces/CommentaryLine';
import { defineComponent, PropType, ref, watchEffect } from 'vue';

export default defineComponent({
  props: {
    line: Object as PropType<CommentaryLine>,
    previous: Object as PropType<CommentaryLine>,
  },
  setup(props) {
    const verse = ref<string>('');
    const decade = ref<string>('');
    const part = ref<string>('');

    function toRomanNumeral(n: number): string {
      const lookup: Record<string, number> = {
        M: 1000,
        CM: 900,
        D: 500,
        CD: 400,
        C: 100,
        XC: 90,
        L: 50,
        XL: 40,
        X: 10,
        IX: 9,
        V: 5,
        IV: 4,
        I: 1,
      };
      let num = n;
      let roman = '';
      const keys = Object.keys(lookup);
      keys.forEach((key) => {
        while (num >= lookup[key]) {
          roman += key;
          num -= lookup[key];
        }
      });

      return roman;
    }

    watchEffect(() => {
      if (props.line !== undefined && props.previous !== undefined) {
        if (props.line.verse !== props.previous.verse) {
          verse.value = props.line.verse.toString();
        }
        if (props.line.decade !== props.previous.decade) {
          decade.value = props.line.decade.toString();
        }
        if (props.line.main_part !== props.previous.main_part) {
          part.value = toRomanNumeral(props.line.main_part);
        }
      } else if (props.line !== undefined) {
        verse.value = props.line.verse.toString();
      }
    });
    return { verse, decade, part };
  },
});
</script>
