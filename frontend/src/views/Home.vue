<template>
  <div class="flex flex-col">
    <router-view />
  </div>
</template>

<script lang="ts">
import { defineComponent, computed, ref, watch } from 'vue';
import { getEvents, events, getCollegium } from '@/api/academic_event';
import SectionHeader from '@/components/global/SectionHeader.vue';
import { isLoaded } from '@/interfaces/RemoteData';
import ArticleContainer from '@/components/global/ArticleContainer.vue';
import { useRoute } from 'vue-router';
import { useMeta } from 'vue-meta';
import { useI18n } from 'vue-i18n';

export default defineComponent({});
</script>
