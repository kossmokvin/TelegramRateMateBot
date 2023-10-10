<template>
  <div class="anonymous-checkbox flex items-center" @click="showPopup">
    <NiceCheckbox
      v-model="userReview.anonymous"
      :disabled="!isPremiumUser"
      id="anonymous-extended"
      label="Anonymous"
    />
    <NiceIcon icon="premium" class="ms-1" />
  </div>
</template>


<script>
import useReviews from "@/composables/useReviews.js";
import useInitData from "@/composables/useInitData.js";
import NiceIcon from "@/components/ui/NiceIcon.vue";
import NiceCheckbox from "@/components/ui/NiceCheckbox.vue";

export default {
  name: "ReviewAnonymousCheckbox",
  components: {
    NiceIcon,
    NiceCheckbox,
  },
  setup() {
    const { userReview } = useReviews();
    const { isPremiumUser } = useInitData();

    const showPopup = () => {
      const title = "Blocked";
      const message =
        "Anonymous posting of reviews is available to Telegram Premium users only";
      window.Telegram?.WebApp?.showPopup({
        title,
        message,
      });
    };

    return {
      userReview,
      isPremiumUser,
      showPopup,
    };
  },
};
</script>
