<script setup>
import { useI18n } from 'vue-i18n';
import { computed, ref } from 'vue';
import { PhotoIcon } from '@heroicons/vue/24/outline';
import useLanguage from '@/Composables/useLanguage.js';
import InputField from '@/Components/InputField.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextAreaField from '@/Components/TextAreaField.vue';
import ChooseEditingLanguage from '@/Components/ChooseEditingLanguage.vue';

// Define emits
const emit = defineEmits(['update:form']);

// Define props
const props = defineProps({
	form: {
		type: Object,
		required: true
	},
	canEdit: {
		type: Boolean,
		default: true
	}
});

// Set translation
const { t } = useI18n();

// Define variables
const threeSixtyInput = ref(null);
const ThreeSixtyPreview = ref(null);

// Define computed variables
const threeSixtyAreaForm = computed({
	get() {
		return props.form;
	},
	set(value) {
		emit('update:form', value);
	}
});

// Get language composable
const { editingLanguage, setEditingLanguage } = useLanguage();

// Define functions
function updatePhotoPreview() {
	const photoFile = threeSixtyInput.value.$el.files[0];

	if (!photoFile) return;

	const reader = new FileReader();

	reader.onload = (e) => {
		ThreeSixtyPreview.value = e.target.result;
		threeSixtyAreaForm.value.new_image = photoFile;
		emit('update:form', threeSixtyAreaForm.value);
	};

	reader.readAsDataURL(photoFile);
}

function selectNewThreeSixty() {
	threeSixtyAreaForm.value.image = null;
	threeSixtyInput.value.$el.click();
}

function deleteThreeSixty() {
	// Reset
	ThreeSixtyPreview.value = null;
	threeSixtyAreaForm.value.image = null;
	threeSixtyAreaForm.value.new_image = null;

	// Clear three sixty input
	clearThreeSixtyInput();

	// Update form in parent
	emit('update:form', threeSixtyAreaForm.value);
}

function clearThreeSixtyInput() {
	if (threeSixtyInput.value?.value) {
		threeSixtyInput.value.value = null;
	}
}
</script>

<template>
	<form @submit.prevent>
		<div class="flex flex-col gap-8">
			<div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
				<div class="sm:col-span-6">
					<ChooseEditingLanguage @language="setEditingLanguage" />
				</div>

				<div class="sm:col-span-3">
					<InputLabel for="name" :value="t('spa.labels.name')" />

					<InputField
						v-model="threeSixtyAreaForm.name[editingLanguage]"
						type="text"
						name="name"
						id="name"
						class="mt-1 block w-full"
						:disabled="!canEdit"
					/>

					<InputError :message="threeSixtyAreaForm.errors.name" class="mt-2" />
				</div>

				<div class="sm:col-span-3">
					<InputLabel for="is_default" :value="t('spa.labels.is_default')" />

					<InputField
						v-model="threeSixtyAreaForm.is_default"
						type="checkbox"
						name="is_default"
						id="is_default"
						class="mt-1 block"
						:disabled="!canEdit"
					/>

					<InputError :message="threeSixtyAreaForm.errors.is_default" class="mt-2" />
				</div>

				<div class="sm:col-span-6">
					<InputLabel for="description" :value="t('spa.labels.description')" />

					<TextAreaField
						v-model="threeSixtyAreaForm.description[editingLanguage]"
						type="text"
						name="description"
						id="description"
						class="mt-1 block w-full"
						:disabled="!canEdit"
					/>

					<InputError :message="threeSixtyAreaForm.errors.description" class="mt-2" />
				</div>

				<div class="sm:col-span-3">
					<InputLabel for="image" :value="t('spa.labels.image')" />

					<div
						class="mt-2 flex flex-col gap-4 justify-center rounded-lg border border-dashed border-gray-900/25 p-4"
					>
						<InputField
							ref="threeSixtyInput"
							type="file"
							class="hidden"
							accept=".png, .jpg, .jpeg, .webp"
							@change="updatePhotoPreview"
						/>

						<div v-if="threeSixtyAreaForm.image && threeSixtyAreaForm.image.original_url">
							<img
								:src="threeSixtyAreaForm.image.original_url"
								alt="three sixty image"
								class="w-full aspect-video object-cover"
							/>
						</div>

						<div v-else class="relative">
							<span
								class="block aspect-video w-full bg-cover bg-no-repeat bg-center rounded-md"
								:class="{ 'bg-gray-300': !ThreeSixtyPreview }"
								:style="'background-image: url(\'' + ThreeSixtyPreview + '\');'"
							/>

							<PhotoIcon
								v-if="!ThreeSixtyPreview"
								class="absolute z-10 top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 w-14 h-14 text-white"
							/>
						</div>

						<InputError :message="threeSixtyAreaForm.errors.new_image" class="mt-2" />

						<div v-if="canEdit" class="flex justify-start items-center gap-3">
							<SecondaryButton
								v-if="threeSixtyAreaForm.image || ThreeSixtyPreview"
								type="button"
								class="w-fit"
								@click="deleteThreeSixty"
							>
								{{ t('spa.buttons.remove') }}
							</SecondaryButton>

							<PrimaryButton class="w-fit" type="button" @click="selectNewThreeSixty">
								{{ t('spa.buttons.add') }}
							</PrimaryButton>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</template>
