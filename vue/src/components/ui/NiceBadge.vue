<template>
  <span
    class="inline-flex items-center rounded-md bg-orange-50 px-2 py-1 text-xs font-medium text-orange-700 ring-1 ring-inset ring-orange-600/10"
  >
    <slot></slot>
  </span>
</template>

<script>
export default {
  name: "NiceBadge",
};
</script>
