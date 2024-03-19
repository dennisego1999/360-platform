<script setup>
import { useI18n } from 'vue-i18n';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { EyeIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/20/solid/index.js';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

// Define options
defineOptions({
	layout: AppLayout
});

// Define props
defineProps({
	areas: Array
});

// Set translation
const { t } = useI18n();
</script>

<template>
	<div>
		<Head :title="t('spa.pages.three_sixty_generator.areas.index.label')" />

		<div class="flex flex-col gap-6">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold leading-6 text-gray-900">
						{{ t('spa.pages.three_sixty_generator.areas.index.label') }}
					</h1>

					<p class="mt-2 text-sm text-gray-700">
						{{ t('spa.pages.three_sixty_generator.areas.index.description') }}
					</p>
				</div>

				<PrimaryButton :href="route('admin.three-sixty-generator.area.create')">
					{{ t('spa.buttons.create_360_area') }}
				</PrimaryButton>
			</div>

			<ul
				v-if="areas.length !== 0"
				role="list"
				class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl"
			>
				<li
					v-for="area in areas"
					:key="area.id"
					class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6"
				>
					<div class="flex items-center min-w-0">
						<p class="text-sm font-semibold leading-6 text-gray-900">
							{{ area.name }}
						</p>
					</div>

					<div class="flex shrink-0 items-center gap-x-4">
						<SecondaryButton
							:href="
								route('admin.three-sixty-generator.viewpoint.index', {
									area: area
								})
							"
						>
							{{ t('spa.buttons.viewpoints') }}
						</SecondaryButton>

						<Link
							:href="route('admin.three-sixty-generator.area.show', { area: area })"
							class="flex shrink-0 items-center gap-1"
						>
							<div class="p-2 rounded-md bg-gray-300 cursor-pointer">
								<EyeIcon class="h-5 w-5 flex-none text-white" />
							</div>
						</Link>

						<Link
							v-if="usePage().props.policies.can.manageThreeSixties"
							:href="route('admin.three-sixty-generator.area.edit', { area: area })"
							class="flex shrink-0 items-center gap-1"
						>
							<div class="p-2 rounded-md bg-gray-300 cursor-pointer">
								<PencilSquareIcon class="h-5 w-5 flex-none text-white" />
							</div>
						</Link>

						<Link
							v-if="usePage().props.policies.can.manageThreeSixties"
							:href="
								route('admin.three-sixty-generator.area.destroy', {
									area: area
								})
							"
							method="delete"
							as="button"
							class="flex shrink-0 items-center gap-1"
						>
							<div class="p-2 rounded-md bg-red-400 cursor-pointer">
								<TrashIcon class="h-5 w-5 flex-none text-white" />
							</div>
						</Link>
					</div>
				</li>
			</ul>

			<p v-else>{{ t('spa.pages.three_sixty_generator.areas.index.no_areas') }}</p>
		</div>
	</div>
</template>
