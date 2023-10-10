<template>
  <AppPage />
</template>

<script>
import AppPage from "@/components/AppPage.vue";

export default {
  name: "App",
  components: {
    AppPage,
  },
};
</script>

<style lang="scss">
html,
body {
  background: var(--tg-theme-bg-color);
  color: var(--tg-theme-text-color);
}
</style>
