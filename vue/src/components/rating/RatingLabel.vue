<template>
  <div class="flex items-center bg-tg-background px-2 py-1 rounded-full">
    <div class="me-2 text-xs font-medium text-tg-hint">
      {{ ratingText }}
    </div>
    <NiceIcon :icon="'rating' + ratingInt" class="review__rating-icon" />
  </div>
</template>

<script>
import { computed } from "vue";
import NiceIcon from "@/components/ui/NiceIcon.vue";

export default {
  name: "RatingLabel",
  components: {
    NiceIcon,
  },
  props: {
    rating: Number,
  },
  setup(props) {
    const ratingInt = computed(() => {
      const defaultRating = 5;
      return Math.floor(props.rating) || defaultRating;
    });

    const ratingText = computed(() => {
      const texts = ["", "Terrible", "Bad", "Okay", "Good", "Great"];
      return texts[ratingInt.value];
    });

    return { ratingInt, ratingText };
  },
};
</script>
