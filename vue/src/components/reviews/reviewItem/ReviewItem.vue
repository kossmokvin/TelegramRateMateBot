<template>
  <div class="review-item">
    <transition name="fade" mode="out-in">
      <ReviewItemForm v-if="editable && review.editMode" class="mb-7" />
      <ReviewItemDisplay v-else :review="review" :editable="editable" />
    </transition>
  </div>
</template>

<script>
import { ref } from "vue";
import ReviewItemDisplay from "@/components/reviews/reviewItem/ReviewItemDisplay.vue";
import ReviewItemForm from "@/components/reviews/reviewItem/ReviewItemForm.vue";

export default {
  name: "ReviewsItem",
  components: {
    ReviewItemDisplay,
    ReviewItemForm,
  },
  props: {
    review: Object,
    editable: Boolean,
  },
  setup() {
    const mode = ref("display");

    return { mode };
  },
};
</script>
