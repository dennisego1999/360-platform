<script setup>
import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import Modal from '@/Components/Modal.vue';
import { useI18n } from 'vue-i18n';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

// Set translation
const { t } = useI18n();

// Set variables
const selectedLocale = ref(null);
const isModalOpen = ref(false);

// Set computed variables
const currentLocale = computed(() => {
	return usePage().props.locales.find((locale) => locale.is_current);
});

// Define functions
function openModal(locale) {
	// Set reactive
	selectedLocale.value = locale;

	// Open
	isModalOpen.value = true;
}

function closeModal() {
	// Close
	isModalOpen.value = false;

	// Reset reactive
	selectedLocale.value = null;
}

function reloadToRequestedLocale() {
	window.location.href = selectedLocale.value.url;

	// Close modal
	closeModal();
}
</script>

<template>
	<Dropdown :angle="usePage().props.locales.length > 1" :width="'fit'">
		<template #trigger>
			<div class="uppercase">
				{{ currentLocale?.code }}
			</div>
		</template>

		<template #content>
			<div
				v-for="(data, contentIndex) in usePage().props.locales.filter((locale) => locale !== currentLocale)"
				:key="'content-locale-' + contentIndex"
				class="transition-all hover:bg-gray-50 px-3 uppercase"
				@click="openModal(data)"
			>
				{{ data.code }}
			</div>
		</template>
	</Dropdown>

	<Modal :show="isModalOpen" max-width="md" @close="closeModal">
		<div class="flex flex-col gap-2">
			<p>{{ t('spa.modals.change_language', { locale: t('locales.' + selectedLocale.code) }) }}</p>

			<div class="flex justify-start items-center gap-2">
				<SecondaryButton @click="closeModal">
					{{ t('spa.buttons.no') }}
				</SecondaryButton>

				<PrimaryButton @click="reloadToRequestedLocale">
					{{ t('spa.buttons.yes') }}
				</PrimaryButton>
			</div>
		</div>
	</Modal>
</template>
