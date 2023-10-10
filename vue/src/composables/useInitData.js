import { ref, computed } from "vue";
import { queryStringToObject } from "@/helpers/urlHelper";
import { mock__initData } from "@/mocks";

export default function useInitData() {
  // Initial string which we recieve from Telegram Mini App
  const initData = ref(window.Telegram?.WebApp?.initData || mock__initData);

  // Parsed initData to use inside application
  const tgData = computed(() => {
    if (!initData.value) return {};

    const decodedStr = decodeURIComponent(initData.value);
    return queryStringToObject(decodedStr);
  });

  // Has the current user the Telegram Premium Status
  const isPremiumUser = computed(() => {
    return tgData.value?.user?.is_premium;
  });

  return {
    isPremiumUser,
    initData,
    tgData
  };
}
