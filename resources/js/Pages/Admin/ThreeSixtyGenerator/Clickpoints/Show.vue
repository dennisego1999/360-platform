<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { Head, useForm } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ThreeSixtyClickpointForm from '@/Components/ThreeSixtyClickpointForm.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

// Define options
defineOptions({
	layout: AppLayout
});

// Define props
const props = defineProps({
	area: Object,
	viewpoint: Object,
	clickpoint: Object,
	contentTypes: Array,
	viewpoints: Array
});
// Set translation
const { t } = useI18n();

// Set variables
const formComponent = ref();
const form = useForm({
	name: props.clickpoint.name ?? {},
	coordinates: props.clickpoint.coordinates ?? {},
	content: props.clickpoint.content ?? {},
	content_type: props.clickpoint.content_type ?? props.contentTypes[0]
});

// Define functions
function setHotspotFromData() {
	formComponent.value.setHotSpotProgrammatically(
		props.clickpoint.coordinates.pitch,
		props.clickpoint.coordinates.yaw
	);
}
</script>

<template>
	<div>
		<Head :title="t('spa.pages.three_sixty_generator.clickpoints.show.label')" />

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
					<SecondaryButton
						:href="
							route('admin.three-sixty-generator.clickpoint.index', { area: area, viewpoint: viewpoint })
						"
					>
						{{ t('spa.buttons.go_back') }}
					</SecondaryButton>

					<PrimaryButton
						:href="
							route('admin.three-sixty-generator.clickpoint.edit', {
								area: area,
								viewpoint: viewpoint,
								clickpoint: clickpoint
							})
						"
					>
						{{ t('spa.buttons.edit') }}
					</PrimaryButton>
				</div>
			</div>

			<ThreeSixtyClickpointForm
				ref="formComponent"
				v-model:form="form"
				:content-types="contentTypes"
				:viewpoints="viewpoints"
				:src="props.viewpoint.image.original_url"
				:can-edit="false"
				@ready="setHotspotFromData"
			/>
		</div>
	</div>
</template>
