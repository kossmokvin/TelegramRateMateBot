<template>
  <form @submit.prevent="addReview" class="form max-w-xl mx-auto text-center">
    <!-- Emojie rating control element -->
    <RatingControl v-model="userReview.rating" class="mb-3" />

    <!-- Form components -->
    <transition name="fade" mode="out-in">
      <!-- Full Form with textarea if comment is shown -->
      <div v-if="isCommentShown">
        <ReviewCommentTextarea />
        <ReviewSubmitButton />
      </div>

      <!-- Mini Form if comment is hidden -->
      <div v-else class="max-w-xs mx-auto">
        <!-- Add comment' link button and Anonymous checkbox  -->
        <div class="flex justify-between text-xs px-2">
          <ReviewCommentLink @click.prevent="toogleCommentShow" />
          <ReviewAnonymousCheckbox />
        </div>
        <!-- Submit button -->
        <ReviewSubmitButton />
      </div>
    </transition>
  </form>
</template>

<script>
import { ref } from "vue";
import useReviews from "@/composables/useReviews.js";
import useChat from "@/composables/useChat.js";
import useInitData from "@/composables/useInitData.js";
import RatingControl from "@/components/rating/RatingControl.vue";
import ReviewSubmitButton from "./parts/ReviewSubmitButton.vue";
import ReviewCommentLink from "./parts/ReviewCommentLink.vue";
import ReviewAnonymousCheckbox from "./parts/ReviewAnonymousCheckbox.vue";
import ReviewCommentTextarea from "./parts/ReviewCommentTextarea.vue";

export default {
  name: "ReviewItemForm",
  components: {
    ReviewCommentTextarea,
    ReviewAnonymousCheckbox,
    RatingControl,
    ReviewCommentLink,
    ReviewSubmitButton,
  },
  setup() {
    const {
      add,
      loadingAdd,
      userReview,
      toggleEditMode,
      updateUserReviewTime,
    } = useReviews();
    const { chat, fetch: fetchChat } = useChat();
    const { tgData, isPremiumUser } = useInitData();

    const isCommentShown = ref(userReview.comment);
    const toogleCommentShow = () => {
      isCommentShown.value = !isCommentShown.value;
    };

    const addReview = async () => {
      updateUserReviewTime();
      toggleEditMode();

      const response = await add(userReview);
      if (response) fetchChat();
    };

    return {
      isCommentShown,
      toogleCommentShow,
      chat,
      tgData,
      addReview,
      userReview,
      loadingAdd,
      isPremiumUser,
    };
  },
};
</script>
