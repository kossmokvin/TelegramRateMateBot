<template>
  <div class="review ps-5 pe-3 py-3 rounded-lg bg-tg-background2">
    <!-- Review Header -->
    <div class="review__header flex justify-between items-center">
      <!-- Review Info about author and creation date -->
      <div class="review__info text-xs flex justify-between flex-wrap">
        <ReviewAuthor :review="review" />
        <ReviewPublishedTime :review="review" />
      </div>

      <!-- Review Rating and Control Buttons -->
      <div class="flex items-center">
        <ReviewEditLink v-if="editable" @click.prevent="toggleEditMode" />
        <RatingLabel :rating="review.rating" />
      </div>
    </div>

    <!-- Review Body with comment Text if the comment added -->
    <div v-if="review.comment" class="review__body">
      <div class="review__comment text-sm p-2 ps-0 whitespace-break-spaces">
        {{ review.comment }}
      </div>
    </div>
  </div>
</template>

<script>
import ReviewAuthor from "./parts/ReviewAuthor.vue";
import ReviewEditLink from "./parts/ReviewEditLink.vue";
import ReviewPublishedTime from "./parts/ReviewPublishedTime.vue";
import RatingLabel from "@/components/rating/RatingLabel.vue";
import useReviews from "@/composables/useReviews.js";

export default {
  name: "ReviewsItemDisplay",
  components: {
    ReviewAuthor,
    RatingLabel,
    ReviewEditLink,
    ReviewPublishedTime,
  },
  props: {
    review: Object,
    editable: Boolean,
  },
  setup() {
    const { toggleEditMode } = useReviews();
    return { toggleEditMode };
  },
};
</script>
