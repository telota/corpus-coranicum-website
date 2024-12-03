<template>
  <div class="lg:flex">
    <div class="flex-grow w-full lg:pr-3">
      <slot name="first"></slot>
    </div>
    <div class="flex-grow w-full lg:pl-3">
      <slot name="second"></slot>
    </div>
  </div>
</template>
