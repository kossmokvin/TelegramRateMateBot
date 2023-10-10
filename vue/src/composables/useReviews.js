import { ref, reactive, computed } from "vue";
import axios from "axios";
import useInitData from "@/composables/useInitData";
import endpoints from "@/config/apiEndpoints";

const { initData, tgData } = useInitData();

const reviews = ref([]);
const loadingAdd = ref(false);
const loadingFetch = ref(false);
const page = ref(1);
const isLastPage = ref(null);
const total = ref(null);

const userReview = reactive({
  comment: "",
  rating: 4,
  created_at: null,
  uodated_at: null,
  anonymous: false,
  author: {
    id: tgData.value?.user?.id ?? null,
    username: tgData.value?.user?.username ?? "",
    first_name: tgData.value?.user?.first_name ?? "",
    last_name: tgData.value?.user?.last_name ?? "",
    is_premium: tgData.value?.user?.is_premium ?? false
  },
  editMode: true, // show Review Item Form or Review Item Display
  published: false, // is current review is published (including in progress of publishing)
  serverInitChecked: false // have we already received response from server does userReview already exist
});

export default function useReviews() {
  const fetch = async () => {
    loadingFetch.value = true;

    try {
      const response = await axios.get(endpoints.getReviews, {
        params: {
          tgInitData: initData.value,
          page: page.value,
          perPage: 10
        }
      });

      if (response?.data?.success) {
        page.value += 1; // Iterate page each success request

        reviews.value.push(...response.data.reviews);
        isLastPage.value = response.data.isLastPage;
        total.value = response.data.total;
        setUserReview(response.data.userReview);
      }
    } catch (error) {
      console.error("An error occurred in useReviews/fetch():", error);
    } finally {
      loadingFetch.value = false;
    }
  };

  const add = async (review) => {
    loadingAdd.value = true;

    try {
      const response = await axios.get(endpoints.addReview, {
        params: {
          tgInitData: initData.value,
          comment: review.comment,
          rating: review.rating,
          anonymous: review.anonymous
        }
      });

      if (response?.data?.success) {
        console.log("Success useReviews/add()", review);
        return { success: true, review };
      } else {
        console.error("Failed useReviews/add()", response?.data);
        return { error: true, review };
      }
    } catch (error) {
      console.error("An error occurred in useReviews/add():", error);
      return { error: true, review };
    } finally {
      loadingAdd.value = false;
    }
  };

  // A list of all chat reviews without a review of current user
  const communityReviews = computed(() => {
    return reviews.value?.filter(
      (r) => r.author?.id !== tgData.value?.user?.id
    );
  });

  // Helper to update reactive userReview object
  const setUserReview = (review) => {
    userReview.serverInitChecked = true;
    if (review) {
      userReview.comment = review.comment;
      userReview.rating = review.rating;
      userReview.created_at = review.created_at;
      userReview.updated_at = review.updated_at;
      userReview.anonymous = review.anonymous;
      userReview.editMode = false;
      userReview.published = true;
    } else {
      userReview.published = false;
    }
  };

  // Switcher between "Rate this Chat" Form and "Your review" UI display
  // if(editMode === true) ReviewItemForm.vue is shown as UserReview
  // if(editMode === false) ReviewItemDisplat.vue is shown as UserReview
  const toggleEditMode = () => {
    userReview.editMode = !userReview.editMode;
  };

  const updateUserReviewTime = () => {
    const now = new Date();
    if (!userReview.created_at) {
      userReview.created_at = now;
    } else {
      userReview.updated_at = now;
    }
  };

  return {
    add,
    fetch,
    page,
    reviews,
    communityReviews,
    userReview,
    isLastPage,
    loadingAdd,
    loadingFetch,
    toggleEditMode,
    updateUserReviewTime
  };
}
