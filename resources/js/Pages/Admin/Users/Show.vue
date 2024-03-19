<script setup>
import { useI18n } from 'vue-i18n';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputField from '@/Components/InputField.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Layout from '@/Layouts/Layout.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';

// Define options
defineOptions({
	layout: [Layout, DashboardLayout]
});

// Define props
defineProps({
	user: Object
});

// Set translation
const { t } = useI18n();
</script>

<template>
	<form @submit.prevent>
		<div class="flex flex-col gap-8">
			<div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
				<div class="sm:col-span-3">
					<InputLabel for="first-name" :value="t('spa.labels.first_name')" />

					<InputField
						v-model="user.first_name"
						type="text"
						name="first-name"
						id="first-name"
						class="mt-1 block w-full cursor-text"
						disabled
					/>
				</div>

				<div class="sm:col-span-3">
					<InputLabel for="last-name" :value="t('spa.labels.last_name')" />

					<InputField
						v-model="user.last_name"
						type="text"
						name="last-name"
						id="last-name"
						class="mt-1 block w-full cursor-text"
						disabled
					/>
				</div>

				<div class="sm:col-span-4">
					<InputLabel for="email" :value="t('spa.labels.email')" />

					<InputField
						v-model="user.email"
						type="text"
						name="email"
						id="email"
						class="mt-1 block w-full cursor-text"
						disabled
					/>
				</div>
			</div>
		</div>

		<div class="mt-6 flex items-center justify-start gap-x-6">
			<PrimaryButton :href="route('admin.users.index')">
				{{ t('spa.buttons.go_back') }}
			</PrimaryButton>
		</div>
	</form>
</template>
