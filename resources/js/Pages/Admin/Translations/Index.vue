<script setup>
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { PencilSquareIcon, TrashIcon, ArrowUpTrayIcon, ArrowDownTrayIcon } from '@heroicons/vue/20/solid';
import useLanguage from '@/Composables/useLanguage.js';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SearchBar from '@/Components/SearchBar.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import InputField from '@/Components/InputField.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Layout from '@/Layouts/Layout.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

// Define options
defineOptions({
	layout: [Layout, DashboardLayout]
});

// Define props
defineProps({
	languageLines: Object
});

// Set translation
const { t } = useI18n();

// Get language composable
const { editingLanguage } = useLanguage();

// Get url params
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

// Set forms variable
const form = useForm({
	search: urlParams.get('search') ? urlParams.get('search') : null
});

// Set variables
const editModalTranslation = ref(null);
const isEditTranslationModalOpen = ref(false);
const isImportTranslationsModalOpen = ref(false);
const importForm = useForm({
	file: null
});
const editForm = useForm({
	text: {}
});

// Set computed variables
const currentLocale = computed(() => {
	return usePage().props.locales.find((locale) => locale.is_current);
});

// Define functions
function deleteTranslation(languageLine) {
	router.delete(route('admin.translations.destroy', { language_line: languageLine }));
}

function scanTranslations() {
	router.post(route('admin.translations.scan'));
}

function importTranslations() {
	// Import the uploaded excel
	importForm.post(route('admin.translations.import'), {
		onSuccess: () => {
			// Close the modal
			closeImportTranslationsModal();
		}
	});
}

function editTranslation(languageLine) {
	editForm.put(route('admin.translations.update', { language_line: languageLine }), {
		onSuccess: () => {
			// Close the modal
			closeEditTranslationModal();
		}
	});
}

function handleImportTranslationsFileChange(event) {
	importForm.file = event.target.files[0];
}

function openImportTranslationsModal() {
	isImportTranslationsModalOpen.value = true;
}

function closeImportTranslationsModal() {
	// Set reactive
	isImportTranslationsModalOpen.value = false;
}

function openEditTranslationModal(translation) {
	console.log('opening:', translation);

	// Set reactive
	editModalTranslation.value = translation;

	// Open the modal
	isEditTranslationModalOpen.value = true;
}

function closeEditTranslationModal() {
	// Close the modal
	isEditTranslationModalOpen.value = false;

	// Reset reactive
	editModalTranslation.value = null;

	// Reset form data
	editForm.text = {};
}
</script>

<template>
	<div>
		<Head :title="t('spa.pages.translations.label')" />

		<div class="flex flex-col gap-6">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold leading-6 text-gray-900">
						{{ t('spa.pages.translations.label') }}
					</h1>

					<p class="mt-2 text-sm text-gray-700">
						{{ t('spa.pages.translations.description') }}
					</p>
				</div>

				<div class="flex justify-end items-center gap-4">
					<SecondaryButton @click="openImportTranslationsModal">
						<div class="flex justify-center items-center gap-2">
							<ArrowUpTrayIcon class="h-4 w-4 text-gray-600" />

							<p>{{ t('spa.buttons.import') }}</p>
						</div>
					</SecondaryButton>

					<SecondaryButton :download-file="true" :href="route('admin.translations.export')">
						<div class="flex justify-center items-center gap-2">
							<ArrowDownTrayIcon class="h-4 w-4 text-gray-600" />

							<p>{{ t('spa.buttons.export') }}</p>
						</div>
					</SecondaryButton>

					<PrimaryButton @click="scanTranslations">
						{{ t('spa.buttons.scan') }}
					</PrimaryButton>
				</div>
			</div>

			<SearchBar :form="form" :href="route('admin.translations.index')" />

			<div v-if="languageLines.data.length !== 0" class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
				<div class="inline-block min-w-full align-middle sm:px-6 lg:px-8">
					<div class="grid w-full gap-8 p-8 bg-white overflow-hidden sm:rounded-xl ring-1 ring-gray-900/5">
						<div class="row-start-1 text-left text-sm font-semibold text-gray-900">
							{{ t('spa.pages.translations.table.group') }}
						</div>

						<div class="row-start-1 text-left text-sm font-semibold text-gray-900">
							{{ t('spa.pages.translations.table.key') }}
						</div>

						<div class="row-start-1 text-left text-sm font-semibold text-gray-900">
							<p>
								{{ t('spa.pages.translations.table.locale') + ': ' }}

								<span class="uppercase">
									{{ currentLocale.code }}
								</span>
							</p>
						</div>

						<div class="row-start-1 text-left text-sm font-semibold text-gray-900">
							{{ t('spa.pages.translations.table.updated_at') }}
						</div>

						<div class="row-start-1 text-left text-sm font-semibold text-gray-900">
							{{ t('spa.pages.translations.table.actions') }}
						</div>

						<template v-for="(languageLine, index) in languageLines.data" :key="'language-line-' + index">
							<div class="flex justify-start items-center">
								{{ languageLine.group }}
							</div>

							<div class="flex justify-start items-center">
								{{ languageLine.key }}
							</div>

							<div class="flex justify-start items-center">
								{{ languageLine.text[currentLocale.code] }}
							</div>

							<div class="flex justify-start items-center">
								{{ languageLine.updated_at_formatted }}
							</div>

							<div class="flex justify-start items-center">
								<div class="flex justify-start items-center gap-4 w-fit">
									<div
										@click="openEditTranslationModal(languageLine)"
										class="flex shrink-0 items-center gap-1"
									>
										<div class="p-2 rounded-md bg-gray-300 cursor-pointer">
											<PencilSquareIcon class="h-5 w-5 flex-none text-white" />
										</div>
									</div>

									<div
										@click="deleteTranslation(languageLine)"
										class="flex shrink-0 items-center gap-1"
									>
										<div class="p-2 rounded-md bg-red-400 cursor-pointer">
											<TrashIcon class="h-5 w-5 flex-none text-white" />
										</div>
									</div>
								</div>
							</div>
						</template>
					</div>
				</div>
			</div>

			<p v-else>{{ t('spa.pages.translations.no_translations') }}</p>

			<Pagination v-if="languageLines.data.length !== 0" :links="languageLines.links" />
		</div>

		<Modal :show="isEditTranslationModalOpen" @close="closeEditTranslationModal">
			<form @submit.prevent class="flex flex-col gap-4">
				<div class="flex flex-col gap-4">
					<InputLabel for="group" :value="t('spa.pages.translations.table.group')" />

					<InputField
						id="group"
						type="text"
						name="group"
						class="text w-full"
						:value="editModalTranslation.group"
						disabled
					/>
				</div>

				<div class="flex flex-col gap-4">
					<InputLabel for="key" :value="t('spa.pages.translations.table.key')" />

					<InputField
						id="key"
						type="text"
						name="key"
						class="text w-full"
						:value="editModalTranslation.key"
						disabled
					/>
				</div>

				<div class="flex flex-col gap-4">
					<InputLabel for="text" :value="t('spa.pages.translations.table.original_translation')" />

					<InputField
						id="text"
						type="text"
						name="text"
						class="text w-full"
						:value="editModalTranslation.original_text[editingLanguage]"
						disabled
					/>
				</div>

				<div class="flex flex-col gap-4">
					<InputLabel for="text" :value="t('spa.pages.translations.table.new_translation')" />

					<InputField
						v-model="editForm.text[editingLanguage]"
						id="text"
						type="text"
						name="text"
						class="text w-full"
					/>

					<InputError :message="editForm.errors['text']" />
				</div>

				<div class="flex justify-start items-center gap-4">
					<SecondaryButton @click="closeEditTranslationModal">
						{{ t('spa.buttons.cancel') }}
					</SecondaryButton>

					<PrimaryButton @click="editTranslation(editModalTranslation)">
						{{ t('spa.buttons.edit') }}
					</PrimaryButton>
				</div>
			</form>
		</Modal>

		<Modal :show="isImportTranslationsModalOpen" @close="closeImportTranslationsModal">
			<form @submit.prevent class="flex flex-col gap-4">
				<InputLabel for="file" value="File" />

				<InputField
					id="file"
					type="file"
					name="file"
					accept=".xls, .xlsx"
					class="bg-gray-300 block w-full"
					@change="handleImportTranslationsFileChange"
				/>

				<InputError
					v-for="(error, index) in importForm.errors"
					:key="'import-error-' + index"
					:message="error"
				/>

				<PrimaryButton @click="importTranslations">
					{{ t('spa.buttons.import') }}
				</PrimaryButton>
			</form>
		</Modal>
	</div>
</template>
