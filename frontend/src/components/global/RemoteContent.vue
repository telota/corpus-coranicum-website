<template>
  <div
    v-if="isLoading(data)"
    class="w-2 mx-auto"
    :class="showLoadingSpinner ? 'py-36' : 'py-40'"
  >
    <template v-if="showLoadingSpinner">
      <LoadingSpinner />
    </template>
  </div>
  <slot v-else-if="isLoaded(data)"></slot>
  <div v-else-if="notFound(data)">
    <h2 class="text-center">Error 404. The requested resource could not be found</h2>
  </div>
</template>
<script lang="ts">
import { isLoading, isLoaded, notFound, RemoteData } from '@/interfaces/RemoteData';
import { defineComponent, PropType, ref, Ref } from 'vue';
import LoadingSpinner from './LoadingSpinner.vue';

export default defineComponent({
  components: { LoadingSpinner },
  props: { data: Object as PropType<RemoteData<any>> },
  setup() {
    const showLoadingSpinner: Ref<boolean> = ref(false);
    setTimeout(() => {
      showLoadingSpinner.value = true;
    }, 1000);

    return {
      isLoaded,
      isLoading,
      notFound,
      showLoadingSpinner,
    };
  },
});
</script>
