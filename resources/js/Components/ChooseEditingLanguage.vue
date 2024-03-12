<script setup>
import { useI18n } from 'vue-i18n';
import { usePage } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import Dropdown from '@/Components/Dropdown.vue';

// Define emits
const emit = defineEmits(['language']);

// Define props
defineProps({
	disabled: {
		type: Boolean,
		default: false
	}
});

// Set translation
const { t } = useI18n();

// Set variables
const editingLanguage = ref(usePage().props.current_locale);

// Define function
function setEditingLanguage(code) {
	editingLanguage.value = code;
}

// Watch
watch(editingLanguage, (value) => {
	emit('language', value);
});
</script>

<template>
	<InputLabel for="choose-language" :value="t('spa.labels.choose_language')" />

	<Dropdown
		width="full"
		align="left"
		:disabled="disabled"
		:angle="usePage().props.locales.length > 1"
		:container-classes="[
			'bg-white',
			'p-2',
			'border-gray-300',
			'focus:border-indigo-500',
			'focus:ring-indigo-500',
			'rounded-md',
			'shadow-sm',
			'mt-1',
			'block',
			'w-full'
		]"
	>
		<template #trigger>
			<div class="uppercase">
				{{ editingLanguage }}
			</div>
		</template>

		<template #content>
			<div
				v-for="(data, index) in usePage().props.locales.filter((locale) => locale.code !== editingLanguage)"
				:key="'content-locale-' + index"
				class="transition-all hover:bg-gray-50 p-2 uppercase"
				@click="setEditingLanguage(data.code)"
			>
				{{ data.code }}
			</div>
		</template>
	</Dropdown>
</template>
