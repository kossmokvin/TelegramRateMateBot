<template>
  <h2 :class="['text-' + size, 'font-' + weight]" class="text-center">
    <slot></slot>
  </h2>
</template>

<script>
export default {
  name: "NiceHeading",
  props: {
    weight: {
      type: String,
      default: "medium",
    },
    size: {
      type: String,
      default: "md",
    },
  },
};
</script>
