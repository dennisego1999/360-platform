import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

export default function useLanguage() {
	const editingLanguage = ref(usePage().props.current_locale);
	const currentLocale = computed(() => usePage().props.current_locale);
	const supportedLocales = computed(() => usePage().props.locales);

	function setEditingLanguage(locale) {
		editingLanguage.value = locale;
	}

	return {
		editingLanguage,
		currentLocale,
		supportedLocales,
		setEditingLanguage
	};
}
