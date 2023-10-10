<template>
  <div class="nice-textarea">
    <div class="flex justify-between mb-1 ps-3 pe-2">
      <label :for="textareaId" class="block text-sm text-tg-hint mb-1">
        {{ label }}
      </label>
      <slot name="header"></slot>
    </div>

    <textarea
      :id="textareaId"
      :value="modelValue"
      @input="onInput"
      :maxlength="maxLength"
      class="w-full bg-tg-background2 border-tg-hint p-3 pb-8 border rounded-md shadow-sm focus:ring-2 focus:ring-tg-link focus:border-transparent resize-y"
      :placeholder="placeholder"
      :aria-describedby="hint ? hintId : undefined"
    ></textarea>

    <div class="flex justify-content-between text-xs text-gray-500 px-3">
      <!-- Hint for the textarea -->
      <div v-if="hint" class="mr-4" :id="hintId">{{ hint }}</div>
      <div v-if="maxLength" class="ml-auto">
        {{ charCount }} / {{ maxLength }} characters
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "NiceTextarea",
  props: {
    modelValue: {
      type: String,
      default: "",
    },
    maxLength: {
      type: Number,
      default: 300,
    },
    placeholder: {
      type: String,
      default: "",
    },
    hint: {
      type: String,
      default: "",
    },
    id: {
      required: true,
      type: String,
    },
    // New prop for label text
    label: {
      type: String,
      required: true, // Make it required for accessibility
    },
  },
  computed: {
    charCount() {
      return this.modelValue.length;
    },
    // Generate unique IDs for the textarea and the hint
    textareaId() {
      return `textarea-${this.id}`;
    },
    hintId() {
      return `hint-${this.id}`;
    },
  },
  methods: {
    onInput(event) {
      this.$emit("update:modelValue", event.target.value);
    },
  },
};
</script>
