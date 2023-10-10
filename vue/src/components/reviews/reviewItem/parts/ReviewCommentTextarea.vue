<template>
  <NiceTextarea
    v-model="userReview.comment"
    placeholder="Enter your comment here..."
    label="Comment Text"
    hint="Please be polite"
    id="comment"
    class="mt-2"
  >
    <template #header>
      <ReviewAnonymousCheckbox />
    </template>
  </NiceTextarea>
</template>


<script>
import useReviews from "@/composables/useReviews.js";
import NiceTextarea from "@/components/ui/NiceTextarea.vue";
import ReviewAnonymousCheckbox from "./ReviewAnonymousCheckbox.vue";

export default {
  name: "ReviewCommentTextarea",
  components: {
    NiceTextarea,
    ReviewAnonymousCheckbox,
  },
  setup() {
    const { userReview } = useReviews();

    return {
      userReview,
    };
  },
};
</script>
