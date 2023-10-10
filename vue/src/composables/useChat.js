import { ref, computed } from "vue";
import axios from "axios";
import useInitData from "@/composables/useInitData";
import endpoints from "@/config/apiEndpoints";

const { initData } = useInitData();

const chat = ref(null);
const loading = ref(false);

export default function useChat() {
  const fetch = async () => {
    try {
      loading.value = true;
      const response = await axios.get(endpoints.getChat, {
        params: {
          tgInitData: initData.value
        }
      });
      chat.value = response.data;
    } catch (error) {
      chat.value = null;
      console.error("An error occurred in useChat/fetch():", error);
    } finally {
      loading.value = false;
    }
  };

  const isPrivateChat = computed(() => {
    return chat.value?.type === "Private";
  });

  return {
    fetch,
    chat,
    loading,
    isPrivateChat
  };
}
