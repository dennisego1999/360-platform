<script setup>
import { useI18n } from 'vue-i18n';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import InputField from '@/Components/InputField.vue';
import InputLabel from '@/Components/InputLabel.vue';
import MultiselectDropdown from '@/Components/MultiselectDropdown.vue';
import Layout from '@/Layouts/Layout.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

// Define options
defineOptions({
	layout: [Layout, DashboardLayout]
});

// Define props
defineProps({
	roles: Array
});

// Set translation
const { t } = useI18n();

// Define variables
const form = useForm({
	first_name: null,
	last_name: null,
	email: null,
	password: null,
	password_confirmation: null,
	roles: []
});

// Define functions
function submitForm() {
	form.post(route('admin.users.store'));
}
</script>

<template>
	<form @submit.prevent>
		<div class="flex flex-col gap-8">
			<div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
				<div class="sm:col-span-3">
					<InputLabel for="first-name" :value="t('spa.labels.first_name')" />

					<InputField
						v-model="form.first_name"
						type="text"
						name="first-name"
						id="first-name"
						class="mt-1 block w-full"
						autocomplete="given-name"
					/>

					<InputError :message="form.errors.first_name" class="mt-2" />
				</div>

				<div class="sm:col-span-3">
					<InputLabel for="last-name" :value="t('spa.labels.last_name')" />

					<InputField
						v-model="form.last_name"
						type="text"
						name="last-name"
						id="last-name"
						class="mt-1 block w-full"
						autocomplete="family-name"
					/>

					<InputError :message="form.errors.last_name" class="mt-2" />
				</div>

				<div class="sm:col-span-4">
					<InputLabel for="email" :value="t('spa.labels.email')" />

					<InputField
						v-model="form.email"
						type="text"
						name="email"
						id="email"
						class="mt-1 block w-full"
						autocomplete="username"
					/>

					<InputError :message="form.errors.email" class="mt-2" />
				</div>

				<div class="sm:col-span-3">
					<InputLabel for="password" :value="t('spa.labels.password')" />

					<InputField
						v-model="form.password"
						type="password"
						name="password"
						id="password"
						class="mt-1 block w-full"
						autocomplete="new-password"
					/>

					<InputError :message="form.errors.password" class="mt-2" />
				</div>

				<div class="sm:col-span-3">
					<InputLabel for="password_confirmation" :value="t('spa.labels.password_confirmation')" />

					<InputField
						v-model="form.password_confirmation"
						type="password"
						name="password_confirmation"
						id="password_confirmation"
						class="mt-1 block w-full"
						autocomplete="new-password"
					/>

					<InputError :message="form.errors.password_confirmation" class="mt-2" />
				</div>

				<div class="sm:col-span-4">
					<InputLabel for="roles" :value="t('spa.labels.roles')" />

					<MultiselectDropdown
						v-model="form.roles"
						id="roles"
						class="mt-1"
						:options="roles"
						attribute="name"
					/>

					<InputError :message="form.errors.roles" class="mt-2" />
				</div>
			</div>
		</div>

		<div class="mt-6 flex items-center justify-start gap-x-6">
			<SecondaryButton :href="route('admin.users.index')">
				{{ t('spa.buttons.cancel') }}
			</SecondaryButton>

			<PrimaryButton @click="submitForm">
				{{ t('spa.buttons.save') }}
			</PrimaryButton>
		</div>
	</form>
</template>
