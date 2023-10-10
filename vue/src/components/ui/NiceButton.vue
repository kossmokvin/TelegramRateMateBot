<template>
  <button
    class="nice-button bg-tg-button text-tg-button-text font-semibold px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2"
  >
    <slot></slot>
  </button>
</template>

<script>
export default {
  name: "NiceButton",
};
</script>