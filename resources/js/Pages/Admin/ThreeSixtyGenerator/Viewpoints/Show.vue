<script setup>
import { useI18n } from 'vue-i18n';
import { Head, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ThreeSixtyViewpointForm from '@/Components/ThreeSixtyViewpointForm.vue';

// Define options
defineOptions({
	layout: [Layout, DashboardLayout]
});

// Define props
const props = defineProps({
	area: Object,
	viewpoint: Object
});

// Set translation
const { t } = useI18n();

// Set variables
const form = useForm({
	name: props.viewpoint.name ?? null,
	description: props.viewpoint.description ?? null,
	is_default: props.viewpoint.is_default ?? false,
	image: props.viewpoint.image ?? null,
	new_image: null
});
</script>

<template>
	<div>
		<Head :title="t('spa.pages.three_sixty_generator.view_points.show.label')" />

		<div class="flex flex-col gap-6">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold leading-6 text-gray-900">
						{{ t('spa.pages.three_sixty_generator.areas.show.label') }}
					</h1>

					<p class="mt-2 text-sm text-gray-700">
						{{ t('spa.pages.three_sixty_generator.areas.show.description') }}
					</p>
				</div>

				<div class="flex justify-between items-center gap-4">
					<SecondaryButton :href="route('admin.three-sixty-generator.viewpoint.index', { area: area })">
						{{ t('spa.buttons.go_back') }}
					</SecondaryButton>

					<PrimaryButton
						:href="
							route('admin.three-sixty-generator.viewpoint.edit', {
								area: area,
								viewpoint: viewpoint
							})
						"
					>
						{{ t('spa.buttons.edit') }}
					</PrimaryButton>
				</div>
			</div>

			<ThreeSixtyViewpointForm v-model:form="form" :can-edit="false" />
		</div>
	</div>
</template>
