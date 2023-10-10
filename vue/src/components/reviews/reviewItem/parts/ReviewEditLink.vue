<template>
  <NiceLink
    href="#editReview"
    title="Edit comment"
    class="text-xs me-1 font-semibold bg-tg-background px-3 py-1 rounded-full"
    style="padding: 6px 10px"
  >
    <span>Edit</span>
  </NiceLink>
</template>


<script>
import NiceLink from "@/components/ui/NiceLink.vue";

export default {
  name: "ReviewEditLink",
  components: {
    NiceLink,
  },
};
</script>
