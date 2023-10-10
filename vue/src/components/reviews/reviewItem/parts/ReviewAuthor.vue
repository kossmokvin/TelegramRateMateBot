<template>
  <NiceLink
    v-if="!review.anonymous && link"
    :href="link"
    @click="openTelegramLink"
    title="Review Author"
    class="font-bold me-2"
  >
    {{ name }}
  </NiceLink>
  <div v-else class="font-bold me-1 flex">
    <NiceIcon icon="premium" class="me-1" />
    <span>{{ name }}</span>
  </div>
</template>


<script>
import { computed } from "vue";
import NiceIcon from "@/components/ui/NiceIcon.vue";
import NiceLink from "@/components/ui/NiceLink.vue";

export default {
  name: "ReviewAuthor",
  components: {
    NiceIcon,
    NiceLink,
  },
  props: {
    review: Object,
  },
  setup(props) {
    const name = computed(() => {
      if (props.review.anonymous) return "Anonymous";

      const usernameWithAt =
        props.review?.author?.username && "@" + props.review.author.username;

      const name = [
        props.review.author?.first_name || "",
        props.review.author?.last_name || "",
      ]
        .join(" ")
        .trim();
      return name || usernameWithAt || "No name";
    });

    const link = computed(() => {
      const username = props.review?.author?.username;
      if (!username) return null;

      return "https://t.me/" + username;
    });

    const openTelegramLink = () => {
      window.Telegram.WebApp.openTelegramLink(link.value);
    };

    return {
      openTelegramLink,
      name,
      link,
    };
  },
};
</script>
