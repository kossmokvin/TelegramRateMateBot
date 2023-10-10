<template>
  <transition name="fadeslide" mode="out-in">
    <div v-if="!initLoading" class="reviews-list py-3">
      <NiceHeading class="mb-3">Community Reviews</NiceHeading>

      <div v-if="communityReviews.length" class="max-w-xl mx-auto">
        <ReviewItem
          v-for="review in communityReviews"
          :key="review.author"
          :review="review"
          class="mb-3"
        />

        <NiceLoading v-if="loadingFetch" class="py-3" />
        <NiceButton
          v-else-if="!isLastPage"
          @click="fetchReviews"
          class="block w-full"
        >
          <span>Load More</span>
        </NiceButton>
      </div>

      <div v-else class="text-center text-sm opacity-50">
        There are no community reviews yet
      </div>
    </div>
  </transition>
</template>

<script>
import { computed, onBeforeMount } from "vue";
import useReviews from "@/composables/useReviews.js";
import ReviewItem from "@/components/reviews/reviewItem/ReviewItem.vue";
import NiceButton from "@/components/ui/NiceButton.vue";
import NiceLoading from "@/components/ui/NiceLoading.vue";
import NiceHeading from "@/components/ui/NiceHeading.vue";

export default {
  name: "ReviewsList",
  components: {
    ReviewItem,
    NiceButton,
    NiceLoading,
    NiceHeading,
  },
  setup() {
    const {
      communityReviews,
      fetch: fetchReviews,
      loadingFetch,
      isLastPage,
    } = useReviews();

    onBeforeMount(() => {
      fetchReviews();
    });

    const initLoading = computed(() => {
      return loadingFetch.value && !communityReviews.value?.length;
    });

    return {
      communityReviews,
      loadingFetch,
      initLoading,
      fetchReviews,
      isLastPage,
    };
  },
};
</script>
