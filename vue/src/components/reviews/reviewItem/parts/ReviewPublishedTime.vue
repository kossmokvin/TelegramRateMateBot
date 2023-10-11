<template>
  <span class="text-tg-hint whitespace-nowrap me-2">
    {{ timeDisplay }}
  </span>
</template>

<script>
import { computed } from "vue";
import { timeSince } from "@/helpers/dateHelper.js";

export default {
  name: "ReviewPublishedTime",
  props: {
    review: Object,
  },
  setup(props) {
    const timeDisplay = computed(() => {
      return timeSince(
        new Date(props.review?.updated_at || props.review?.created_at)
      );
    });

    return { timeDisplay };
  },
};
</script>
