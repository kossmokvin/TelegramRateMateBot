import { computed } from "vue";
import {
  beginning,
  body,
  notRelevant,
  personComment,
  personBased
} from "@/config/ratingComments";
import { zeroReviews } from "../config/ratingComments";

// If there are less reviews that this value,
// there will be a special note
// about not enough reviews for relevant rating
const edgeOfRelevancy = 5;

export default function useRating(chat) {
  const rating = computed(() => {
    const rating = chat.value?.rating || 5;
    return Number(rating).toFixed(1);
  });

  const ratingInt = computed(() => {
    return Math.floor(rating.value);
  });

  const comment = computed(() => {
    if (chat.value?.type === "Private") {
      return personComment;
    }

    const count = chat.value?.reviews_count;
    if (count === 0) {
      return zeroReviews;
    } else {
      const end = count < edgeOfRelevancy ? notRelevant : body[rating.value];
      return beginning[ratingInt.value] + end;
    }
  });

  const reviewsQty = computed(() => {
    return chat.value?.reviews_count ?? 0;
  });

  const reviewsQtyText = computed(() => {
    if (chat.value?.type === "Private") {
      return personBased;
    }

    const count = chat.value?.reviews_count;
    const text = count === 1 ? "review" : "reviews";
    return count + " " + text;
  });

  return {
    comment,
    rating,
    reviewsQty,
    reviewsQtyText
  };
}
