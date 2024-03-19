<script setup>
import { useI18n } from 'vue-i18n';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import ThreeSixtyAreaForm from '@/Components/ThreeSixtyAreaForm.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

// Define options
defineOptions({
	layout: AppLayout
});

// Set translation
const { t } = useI18n();

// Set variables
const form = useForm({
	name: {}
});

// Define functions
function submit() {
	form.post(route('admin.three-sixty-generator.area.store'), {
		onError: (error) => {
			console.error(error);
		}
	});
}
</script>

<template>
	<div>
		<Head :title="t('spa.pages.three_sixty_generator.create.label')" />

		<div class="flex flex-col gap-6">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold leading-6 text-gray-900">
						{{ t('spa.pages.three_sixty_generator.areas.create.label') }}
					</h1>

					<p class="mt-2 text-sm text-gray-700">
						{{ t('spa.pages.three_sixty_generator.areas.create.description') }}
					</p>
				</div>

				<div class="flex justify-between items-center gap-4">
					<SecondaryButton :href="route('admin.three-sixty-generator.area.index')">
						{{ t('spa.buttons.go_back') }}
					</SecondaryButton>

					<PrimaryButton @click="submit">
						{{ t('spa.buttons.save') }}
					</PrimaryButton>
				</div>
			</div>

			<ThreeSixtyAreaForm v-model:form="form" />
		</div>
	</div>
</template>
