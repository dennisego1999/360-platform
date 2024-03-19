<script setup>
import { useI18n } from 'vue-i18n';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { EyeIcon, PencilSquareIcon, TrashIcon, CheckBadgeIcon } from '@heroicons/vue/20/solid/index.js';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Layout from '@/Layouts/Layout.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

// Define options
defineOptions({
	layout: [Layout, DashboardLayout]
});

// Define props
defineProps({
	area: Object,
	viewpoint: Object,
	clickpoints: Array
});

// Set translation
const { t } = useI18n();
</script>

<template>
	<div>
		<Head :title="t('spa.pages.three_sixty_generator.clickpoints.index.label')" />

		<div class="flex flex-col gap-6">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold leading-6 text-gray-900">
						{{
							t('spa.pages.three_sixty_generator.clickpoints.index.label', {
								name: viewpoint.name
							})
						}}
					</h1>

					<p class="mt-2 text-sm text-gray-700">
						{{ t('spa.pages.three_sixty_generator.clickpoints.index.description') }}
					</p>
				</div>

				<div class="flex justify-between items-center gap-4">
					<SecondaryButton :href="route('admin.three-sixty-generator.viewpoint.index', { area: area })">
						{{ t('spa.buttons.go_back') }}
					</SecondaryButton>

					<PrimaryButton
						:href="
							route('admin.three-sixty-generator.clickpoint.create', {
								area: area,
								viewpoint: viewpoint
							})
						"
					>
						{{ t('spa.buttons.create_clickpoint') }}
					</PrimaryButton>
				</div>
			</div>

			<ul
				v-if="clickpoints.length !== 0"
				role="list"
				class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl"
			>
				<li
					v-for="clickpoint in clickpoints"
					:key="clickpoint.id"
					class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6"
				>
					<div class="flex justify-start items-center gap-2">
						<p class="text-sm font-semibold leading-6 text-gray-900 min-w-fit">
							{{ clickpoint.name }}
						</p>

						<CheckBadgeIcon v-if="clickpoint.is_default" class="fill-indigo-500 h-4 w-4" />
					</div>

					<div class="flex shrink-0 items-center gap-x-4">
						<small
							class="text-white grid place-content-center min-w-fit p-2 font-bold rounded bg-indigo-500"
						>
							{{ clickpoint.content_type }}
						</small>

						<Link
							:href="
								route('admin.three-sixty-generator.clickpoint.show', {
									area: area,
									viewpoint: viewpoint,
									clickpoint: clickpoint
								})
							"
							class="flex shrink-0 items-center gap-1"
						>
							<div class="p-2 rounded-md bg-gray-300 cursor-pointer">
								<EyeIcon class="h-5 w-5 flex-none text-white" />
							</div>
						</Link>

						<Link
							v-if="usePage().props.policies.can.manageThreeSixties"
							:href="
								route('admin.three-sixty-generator.clickpoint.edit', {
									area: area,
									viewpoint: viewpoint,
									clickpoint: clickpoint
								})
							"
							class="flex shrink-0 items-center gap-1"
						>
							<div class="p-2 rounded-md bg-gray-300 cursor-pointer">
								<PencilSquareIcon class="h-5 w-5 flex-none text-white" />
							</div>
						</Link>

						<Link
							v-if="usePage().props.policies.can.manageThreeSixties"
							:href="
								route('admin.three-sixty-generator.clickpoint.destroy', {
									area: area,
									viewpoint: viewpoint,
									clickpoint: clickpoint
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

			<p v-else>{{ t('spa.pages.three_sixty_generator.clickpoints.index.no_viewpoints') }}</p>
		</div>
	</div>
</template>
