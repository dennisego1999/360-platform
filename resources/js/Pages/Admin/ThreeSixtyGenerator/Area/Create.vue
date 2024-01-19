<script setup>
import { useI18n } from 'vue-i18n';
import { Head, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputField from '@/Components/InputField.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

// Define options
defineOptions({
	layout: [Layout, DashboardLayout]
});

// Set translation
const { t } = useI18n();

// Set variables
const form = useForm({
	name: null,
	slug: null
});

// Define functions
function handleNameChange(event) {
	// Set the slug in the form
	form.slug = event.target.value
		.toLowerCase() // Convert to lowercase
		.replace(/[^a-z0-9]+/g, '-') // Replace non-alphanumeric characters (except numbers) with '-'
		.replace(/^-+|-+$/g, '');
}

function submit() {
	form.post(route('admin.three-sixty-generator.store'));
}
</script>

<template>
	<div>
		<Head :title="t('spa.pages.three_sixty_generator.create.label')" />

		<div class="flex flex-col gap-6">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold leading-6 text-gray-900">
						{{ t('spa.pages.three_sixty_generator.create.label') }}
					</h1>

					<p class="mt-2 text-sm text-gray-700">
						{{ t('spa.pages.three_sixty_generator.create.description') }}
					</p>
				</div>

				<div class="flex justify-between items-center gap-4">
					<SecondaryButton :href="route('admin.three-sixty-generator.index')">
						{{ t('spa.buttons.go_back') }}
					</SecondaryButton>

					<PrimaryButton @click="submit">
						{{ t('spa.buttons.save') }}
					</PrimaryButton>
				</div>
			</div>

			<div>
				<form @submit.prevent>
					<div class="flex flex-col gap-8">
						<div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
							<div class="sm:col-span-3">
								<InputLabel for="name" :value="t('spa.labels.name')" />

								<InputField
									v-model="form.name"
									type="text"
									name="name"
									id="name"
									class="mt-1 block w-full"
									@input="handleNameChange"
								/>

								<InputError :message="form.errors.name" class="mt-2" />
							</div>

							<div class="sm:col-span-3">
								<InputLabel for="slug" :value="t('spa.labels.slug')" />

								<InputField
									v-model="form.slug"
									type="text"
									name="slug"
									id="slug"
									class="mt-1 block w-full"
									:disabled="true"
								/>

								<InputError :message="form.errors.slug" class="mt-2" />
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</template>
