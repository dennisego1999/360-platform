<script setup>
import { useI18n } from 'vue-i18n';
import { TrashIcon, EyeIcon, PencilSquareIcon, SparklesIcon } from '@heroicons/vue/20/solid';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SearchBar from '@/Components/SearchBar.vue';
import Layout from '@/Layouts/Layout.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

// Define options
defineOptions({
	layout: [Layout, DashboardLayout]
});

// Define props
defineProps({
	users: Object
});

// Set translation
const { t } = useI18n();

// Get url params
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

// Set forms variable
const form = useForm({
	search: urlParams.get('search') ? urlParams.get('search') : null
});
</script>

<template>
	<div>
		<Head :title="t('spa.pages.users.label')" />

		<div class="flex flex-col gap-6">
			<div class="sm:flex sm:items-center">
				<div class="sm:flex-auto">
					<h1 class="text-base font-semibold leading-6 text-gray-900">
						{{ t('spa.pages.users.label') }}
					</h1>

					<p class="mt-2 text-sm text-gray-700">
						{{ t('spa.pages.users.description') }}
					</p>
				</div>

				<PrimaryButton :href="route('admin.users.create')">
					{{ t('spa.buttons.create_user') }}
				</PrimaryButton>
			</div>

			<SearchBar :form="form" :href="route('admin.users.index')" />

			<div v-if="users.data.length !== 0" class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
				<div class="inline-block min-w-full align-middle sm:px-6 lg:px-8">
					<div
						class="grid grid-cols-[auto,1fr] w-full gap-8 p-8 bg-white overflow-hidden sm:rounded-xl ring-1 ring-gray-900/5"
					>
						<div class="row-start-1 text-left text-sm font-semibold text-gray-900">#</div>

						<div class="row-start-1 text-left text-sm font-semibold text-gray-900">
							{{ t('spa.pages.dashboard.name') }}
						</div>

						<div class="row-start-1 text-left text-sm font-semibold text-gray-900">
							{{ t('spa.pages.dashboard.status') }}
						</div>

						<div class="row-start-1 text-left text-sm font-semibold text-gray-900">
							{{ t('spa.pages.dashboard.roles') }}
						</div>

						<div class="row-start-1 text-left text-sm font-semibold text-gray-900">
							{{ t('spa.pages.dashboard.actions') }}
						</div>

						<template v-for="user in users.data" :key="user.email">
							<div class="flex justify-start items-center">
								{{ user.id }}
							</div>

							<div class="flex justify-start items-center">
								<div class="h-11 w-11 flex-shrink-0">
									<img
										class="h-11 w-11 rounded-full"
										:src="user.profile_photo_url"
										alt="profile image"
									/>
								</div>
								<div class="ml-4">
									<div class="font-medium text-gray-900">{{ user.full_name }}</div>
									<div class="mt-1 text-gray-500">{{ user.email }}</div>
								</div>
							</div>

							<div class="flex justify-start items-center text-sm text-gray-500">
								<div
									v-if="!!user.email_verified_at"
									class="p-1 rounded-md bg-green-400 w-fit pointer-events-none"
								>
									<p class="font-bold text-white">Verified</p>
								</div>

								<div v-else class="p-1 rounded-md bg-blue-400 w-fit pointer-events-none">
									<p class="font-bold text-white">Registered</p>
								</div>
							</div>

							<div class="flex justify-start items-center text-sm text-gray-500">
								<div class="flex flex-wrap justify-start items-center gap-2 w-full">
									<p
										v-for="(role, index) in user.roles"
										:key="'role-' + index"
										class="p-1 rounded-md bg-gray-300"
									>
										{{ role.name }}
									</p>
								</div>
							</div>

							<div class="flex justify-start items-center text-sm text-gray-500">
								<div class="flex justify-start items-center gap-4 w-fit">
									<div
										v-if="usePage().props.policies.can.impersonate"
										@click="router.post(route('admin.impersonate', { user: user }))"
										class="flex shrink-0 items-center gap-1"
									>
										<div class="p-2 rounded-md bg-gray-300 cursor-pointer">
											<SparklesIcon class="h-5 w-5 flex-none text-white" />
										</div>
									</div>

									<Link
										:href="route('admin.users.show', { user: user })"
										class="flex shrink-0 items-center gap-1"
									>
										<div class="p-2 rounded-md bg-gray-300 cursor-pointer">
											<EyeIcon class="h-5 w-5 flex-none text-white" />
										</div>
									</Link>

									<Link
										v-if="usePage().props.policies.can.manageUsers"
										:href="route('admin.users.edit', { user: user })"
										class="flex shrink-0 items-center gap-1"
									>
										<div class="p-2 rounded-md bg-gray-300 cursor-pointer">
											<PencilSquareIcon class="h-5 w-5 flex-none text-white" />
										</div>
									</Link>

									<Link
										v-if="usePage().props.policies.can.manageUsers"
										:href="route('admin.users.destroy', { user: user })"
										method="delete"
										as="button"
										class="flex shrink-0 items-center gap-1"
									>
										<div class="p-2 rounded-md bg-red-400 cursor-pointer">
											<TrashIcon class="h-5 w-5 flex-none text-white" />
										</div>
									</Link>
								</div>
							</div>
						</template>
					</div>
				</div>
			</div>

			<p v-else>{{ t('spa.pages.users.no_users') }}</p>

			<Pagination v-if="users.data.length !== 0" :links="users.links" />
		</div>
	</div>
</template>
