<template>
  <div class="chat-info">
    <div
      class="chat-info__block bg-tg-background2 aspect-square max-w-xs mx-auto p-5 rounded-xl"
      @click="expandApp"
    >
      <transition name="fadeslide" mode="out-in">
        <div v-if="chat && !loading" key="content">
          <div class="chat-info__rating">
            <NiceHeading size="xl" weight="bold">{{ heading }}</NiceHeading>
            <div class="chat-info__rating-value text-8xl font-black my-2">
              {{ rating }}
            </div>
            <div class="chat-info__rating-description">
              <div class="font-medium">
                <span>based on </span>
                <span
                  class="font-bold"
                  :class="[reviewsQty ? 'text-tg-link' : 'text-rose-500 ']"
                  >{{ reviewsQtyText }}</span
                >
              </div>
            </div>
            <div
              class="chat-info__rating-description text-xs text-tg-hint px-7 mt-2"
            >
              {{ comment }}
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import { computed, onBeforeMount } from "vue";
import useChat from "@/composables/useChat.js";
import useRating from "@/composables/useRating.js";
import NiceHeading from "@/components/ui/NiceHeading.vue";

export default {
  name: "ChatInfo",
  components: {
    NiceHeading,
  },
  setup() {
    const { chat, fetch, loading, isPrivateChat } = useChat();
    const { comment, rating, reviewsQty, reviewsQtyText } = useRating(chat);

    const heading = computed(() => {
      const type = isPrivateChat.value ? "Person" : chat.value?.type;
      return (type || "Chat") + " Rating";
    });

    onBeforeMount(() => {
      fetch();
    });

    const expandApp = () => {
      const WebApp = window.Telegram?.WebApp || {};
      if (!WebApp.isExpanded) WebApp.expand();
    };

    return {
      chat,
      heading,
      rating,
      reviewsQty,
      reviewsQtyText,
      comment,
      loading,
      expandApp,
    };
  },
};
</script>

<style lang="scss" scoped>
.chat-info {
  &__block {
    display: flex;
    flex-flow: column;
    align-items: center;
    justify-content: center;
    text-align: center;
  }
}
</style>
