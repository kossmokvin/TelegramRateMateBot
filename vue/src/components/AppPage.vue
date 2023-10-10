<template>
  <transition name="fade" mode="out-in">
    <div v-if="isReady" class="page px-5 pb-9" :class="{ 'is-expanded': isExpanded }">
      <!-- <input type="text" v-model="initData" data-purpose="debugging" class="text-black" /> -->
      <ChatInfo class="mb-3" />
      <UserReview class="mb-3" />
      <ReviewsList />
    </div>
  </transition>
</template>

<script>
import ChatInfo from "@/components/chat/ChatInfo.vue";
import ReviewsList from "@/components/reviews/ReviewsList.vue";
import UserReview from "@/components/reviews/UserReview.vue";
import useInitData from "@/composables/useInitData.js";

import { ref, computed, onMounted } from "vue";

export default {
  name: "AppPage",
  components: {
    ChatInfo,
    ReviewsList,
    UserReview,
  },
  setup() {
    const isReady = ref(false);
    const isExpanded = ref(false);

    onMounted(() => {
      isReady.value = true;
      subscribeOnViewportEvent();
    });

    const subscribeOnViewportEvent = () => {
      const onEvent = window.Telegram?.WebApp?.onEvent;
      onEvent("viewportChanged", () => {
        isExpanded.value = window.Telegram?.WebApp?.isExpanded;
      });
    };

    const { tgData, initData } = useInitData();

    return {
      isReady,
      isExpanded,
      initData: computed(() => JSON.stringify(initData.value)),
      tgData: computed(() => JSON.stringify(tgData.value)),
      themeParams: computed(() => window.Telegram?.WebApp?.themeParams),
    };
  },
};
</script>

<style lang="scss">
.page {
  position: relative;
  top: 0;
  transition: top 0.3s;

  &.is-expanded {
    top: 20px;
  }
}

//* The "enter" transition when the element is inserted. */
.fadeslide-enter-active {
  transition: opacity 1s, transform 1s;
}
.fadeslide-leave-active {
  transition: opacity 0.1s, transform 0.1s;
}

/* The starting state of "enter". */
.fadeslide-enter-from {
  opacity: 0;
  transform: translateY(10px) scale(0.9);
}
.fadeslide-leave-to {
  opacity: 0;
  transform: translateY(-30px) scale(0.8);
}

/* The ending state of "leave". */
.fadeslide-leave-from,
.fadeslide-enter-to {
  opacity: 1;
  transform: translateY(0) scale(1);
}

/* The "enter" transition when the element is inserted. */
.fade-enter-active {
  transition: opacity 1s, transform 1s;
}
.fade-leave-active {
  transition: opacity 0.1s, transform 0.1s;
}

/* The starting state of "enter". */
.fade-enter-from {
  opacity: 0;
}
.fade-leave-to {
  opacity: 0;
}

/* The ending state of "leave". */
.fade-leave-from,
.fade-enter-to {
  opacity: 1;
}
</style>
