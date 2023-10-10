<template>
  <a
    :href="href"
    :title="title"
    class="nice-link text-tg-link transition-colors cursor-pinter"
    :class="{ 'font-bold': bold }"
  >
    <slot></slot>
  </a>
</template>

<script>
export default {
  name: "NiceLink",
  props: {
    href: {
      type: String,
      default: "#",
    },
    title: {
      type: String,
      default: "",
    },
    bold: {
      type: Boolean,
      default: false,
    },
  },
};
</script>