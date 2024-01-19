<script setup>
import { useI18n } from 'vue-i18n';
import { Head, Link, usePage } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { EyeIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/20/solid/index.js';

// Define options
defineOptions({
	layout: [Layout, DashboardLayout]
});

// Define props
defineProps({
	threeSixtyAreas: Array
});

// Set translation
const { t } = useI18n();
</script>

<template>
	<div>
		<Head :title="t('spa.pages.three_sixty_generator.index.label')" />

		<div class="flex flex-col gap-6">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold leading-6 text-gray-900">
						{{ t('spa.pages.three_sixty_generator.index.label') }}
					</h1>

					<p class="mt-2 text-sm text-gray-700">
						{{ t('spa.pages.three_sixty_generator.index.description') }}
					</p>
				</div>

				<PrimaryButton :href="route('admin.three-sixty-generator.create')">
					{{ t('spa.buttons.create_360_area') }}
				</PrimaryButton>
			</div>

			<ul
				v-if="threeSixtyAreas.length !== 0"
				role="list"
				class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl"
			>
				<li
					v-for="area in threeSixtyAreas"
					:key="area.id"
					class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6"
				>
					<div class="flex items-center min-w-0">
						<p class="text-sm font-semibold leading-6 text-gray-900">
							{{ area.name }}
						</p>
					</div>

					<div class="flex shrink-0 items-center gap-x-4">
						<Link
							:href="route('admin.three-sixty-generator.show', { three_sixty_area: area })"
							class="flex shrink-0 items-center gap-1"
						>
							<div class="p-2 rounded-md bg-gray-300 cursor-pointer">
								<EyeIcon class="h-5 w-5 flex-none text-white" />
							</div>
						</Link>

						<Link
							v-if="usePage().props.policies.can.manageThreeSixties"
							:href="route('admin.three-sixty-generator.edit', { three_sixty_area: area })"
							class="flex shrink-0 items-center gap-1"
						>
							<div class="p-2 rounded-md bg-gray-300 cursor-pointer">
								<PencilSquareIcon class="h-5 w-5 flex-none text-white" />
							</div>
						</Link>

						<Link
							v-if="usePage().props.policies.can.manageThreeSixties"
							:href="route('admin.three-sixty-generator.destroy', { three_sixty_area: area })"
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

			<p v-else>{{ t('spa.pages.three_sixty_generator.index.no_areas') }}</p>
		</div>
	</div>
</template>
