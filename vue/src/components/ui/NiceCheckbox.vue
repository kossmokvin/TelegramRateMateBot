<template>
  <div class="nice-checkbox" :class="{ disabled: isDisabled }">
    <!-- Checkbox input -->
    <input
        v-model="isChecked"
        type="checkbox"
        :id="checkboxId"
        :disabled="isDisabled"
        class="hidden"
        @change="onChange"
    />

    <!-- Custom checkbox styling -->
    <label :for="checkboxId" class="flex items-center cursor-pointer text-sm">
      <span
          class="w-4 h-4 mr-2 border border-tg-hint rounded-sm flex items-center justify-center"
      >
        <span
            class="w-3 h-3 rounded-sm inline-block"
            :class="{ 'bg-tg-link': isChecked, 'opacity-70': isDisabled }"
        >
        </span>
      </span>
      <span :class="{ 'text-tg-hint': isDisabled }">{{ label }}</span>
    </label>
  </div>
</template>

<script>
import { ref, computed } from "vue";

export default {
  name: "NiceCheckbox",
  props: {
    modelValue: {
      type: Boolean,
      default: false,
    },
    label: {
      type: String,
      required: true,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    id: {
      type: String,
      required: true,
    },
  },
  setup(props, { emit }) {
    const isChecked = ref(props.modelValue);
    const isDisabled = ref(props.disabled);

    const checkboxId = computed(() => `checkbox-${props.id}`);

    const onChange = (event) => {
      emit("update:modelValue", event.target.checked);
      emit("change", event.target.checked);
    };

    return {
      isChecked,
      isDisabled,
      checkboxId,
      onChange,
    };
  },
};
</script>
