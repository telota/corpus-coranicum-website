<template>
  <div class="bg-green-500 text-white flex justify-center">
    <div class="container pb-8 p-3">
      <div class="md:flex">
        <ul class="pr-20" v-for="links in [linksSetOne, linksSetTwo]" :key="links">
          <li v-for="link in links" :key="link.label()" class="pt-2">
            <router-link :to="link.to">{{ link.label() }}</router-link>
          </li>
        </ul>
        <div class="md:flex-grow">
          <a href="https://www.bbaw.de"
            ><img class="h-28 ml-auto" src="~@/assets/BBAW_Logo.png"
          /></a>
          <a href="https://www.akademienunion.de/"
            ><img class="h-16 ml-auto" src="~@/assets/logo-akademieunion.svg"
          /></a>
        </div>
      </div>
      <p class="mt-4">
        {{ $t('navigation.footer_description') }}
      </p>
    </div>
  </div>
</template>
<script lang="ts">
import { computed, defineComponent, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import NavigationLink from '@/interfaces/NavigationLink';

export default defineComponent({
  setup() {
    const {
      t, locale,
    } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });
    const linksSetOne = computed(() => [
      {
        label: () => t('navigation.faq'),
        to: {
          name: 'FAQ',
          params: { lang: locale.value },
        },
        active: [],
      },
      {
        label: () => t('navigation.contact'),
        to: {
          name: 'Contact',
          params: { lang: locale.value },
        },
        active: [],
      },
      {
        label: () => t('navigation.impressum'),
        to: {
          name: 'Impressum',
          params: { lang: locale.value },
        },
        active: [],
      },
      {
        label: () => t('navigation.privacy_policy'),
        to: {
          name: 'DataProtection',
          params: { lang: locale.value },
        },
        active: [],
      },
    ]);

    const linksSetTwo = computed(() => [
      {
        label: () => t('navigation.about'),
        to: {
          name: 'AboutTheProject',
          params: { lang: locale.value },
        },
        active: [],
      },
      {
        label: () => t('navigation.bibliography'),
        to: {
          name: 'Sources',
          hash: '#zotero',
          params: { lang: locale.value },
        },
        active: [],
      },
      // {
      //   label: () => t('navigation.coranica_font'),
      //   to: {
      //     name: 'Tools',
      //     hash: '#coranicafont',
      //     params: { lang: locale.value },
      //   },
      //   active: [],
      // },
    ]);
    return {
      linksSetOne,
      linksSetTwo,
    };
  },
});
</script>
