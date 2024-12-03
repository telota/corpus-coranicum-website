<template>
  <Modal>
    <h3 class="text-lg text-center" id="modal-title">Oops!</h3>
    <div class="mt-2">
      <p class="pb-4">The following errors occurred in trying to render the site:</p>
      <ul class="list-disc">
        <li v-for="error in errors" :key="error" class="py-1">
          {{ `${error.error} for url '${error.url}'` }}
        </li>
      </ul>
      <p class="pt-5">
        If this problem persists, please contact the webmaster at corpuscoranicum@bbaw.de.
      </p>
    </div>
  </Modal>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import { errors } from '@/api/base';
import Modal from './Modal.vue';

export default defineComponent({
  components: { Modal },
  setup() {
    return { errors };
  },
});
</script>
