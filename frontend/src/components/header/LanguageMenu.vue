<template>
  <div class="relative flex-none">
    <ArrowIcon type="down" :width="20" class="absolute top-2.5 left-8 pointer-events-none" />

    <select
      id="locale-select"
      class="
        border
        text-gray-600
        bg-grey-light
        h-10
        w-14
        pl-1
        pr-1
        bg-white
        appearance-none
        cursor-pointer
      "
      :value="$i18n.locale"
      @change="changeLanguage"
      @input="$emit('selected')"
    >
      <option value="de">DE</option>
      <option value="en">EN</option>
      <option value="fr">FR</option>
    </select>
  </div>
</template>
<script lang="ts">
import { defineComponent, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';
import ArrowIcon from '@/components/icons/ArrowIcon.vue';
import routeParamToString from '@/router/param_as_string';

export default defineComponent({
  components: { ArrowIcon },
  setup() {
    const { locale } = useI18n({
      useScope: 'global',
      inheritLocale: true,
    });

    const route = useRoute();
    watch(
      () => route.params.lang,
      () => {
        const checkedLang = routeParamToString(route.params.lang);
        locale.value = checkedLang;
      },
    );
  },
  methods: {
    changeLanguage(event: any) {
      const lang = event.target.value;
      // Set to expire far in the future, but not too far:
      // https://stackoverflow.com/questions/3290424/set-a-cookie-to-never-expire
      document.cookie = `language=${lang}; expires=Fri 01 Jan 2038 00:00:01 UTC; path=/`;
      const name = String(this.$route.name);
      const params = JSON.parse(JSON.stringify(this.$route.params));
      params.lang = lang;
      this.$router.push({
        name,
        params,
        query: { ...this.$route.query },
      });
    },
  },
});
</script>
