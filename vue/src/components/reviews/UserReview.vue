<template>
  <transition name="fadeslide" mode="out-in">
    <div v-if="!initLoading && !isPrivateChat" class="max-w-xl mx-auto py-3">
      <NiceHeading class="mb-3">{{ heading }}</NiceHeading>
      <ReviewItem :review="userReview" editable />
    </div>
  </transition>
</template>

<script>
import { computed } from "vue";
import useReviews from "@/composables/useReviews.js";
import useChat from "@/composables/useChat.js";
import ReviewItem from "@/components/reviews/reviewItem/ReviewItem.vue";
import NiceHeading from "@/components/ui/NiceHeading.vue";

export default {
  name: "UserReview",
  components: {
    ReviewItem,
    NiceHeading,
  },
  setup() {
    const { loadingFetch, userReview } = useReviews();
    const { chat, isPrivateChat } = useChat();

    const heading = computed(() => {
      if (userReview.editMode) {
        return "Rate this " + (chat.value?.type || "Chat");
      }
      return "Your current Review";
    });

    const initLoading = computed(() => {
      return loadingFetch.value && !userReview.serverInitChecked;
    });

    return {
      heading,
      userReview,
      initLoading,
      isPrivateChat,
      chat,
    };
  },
};
</script>
