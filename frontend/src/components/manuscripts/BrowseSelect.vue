<template>
  <div>
    <label for="category">Browse by:</label>
    <select name="category" id="category">
      <option v-for="o in options" :key="o" value="o">{{ o }}</option>
    </select>
  </div>
</template>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  setup() {
    const options = ['Verse', 'Archive', 'Date', 'Place of Origin'];
    return { options };
  },
});
</script>
