<script setup>
import { onMounted, ref } from 'vue';

defineProps({
	modelValue: [String, Boolean],
	type: String,
	disabled: Boolean
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
	if (input.value.hasAttribute('autofocus')) {
		input.value.focus();
	}
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
	<textarea
		ref="input"
		class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
		rows="4"
		cols="50"
		:value="modelValue"
		:class="{ 'p-4': type === 'file', 'opacity-25': disabled }"
		:disabled="disabled"
		@input="$emit('update:modelValue', type !== 'checkbox' ? $event.target.value : !!input.checked)"
	/>
</template>
