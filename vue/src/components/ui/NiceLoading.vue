<template>
  <div class="flex space-x-3 justify-center">
    <div
      v-for="i in 3"
      :key="i"
      class="animate-pulse h-4 w-4 bg-blue-500 rounded-full"
    ></div>
  </div>
</template>

<script>
export default {
  name: "NiceLoading",
};
</script>

<style scoped>
</style>
