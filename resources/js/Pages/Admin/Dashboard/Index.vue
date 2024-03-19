<script setup>
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Welcome from '@/Components/Welcome.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

// Define options
defineOptions({
	layout: AppLayout
});

// Set translation
const { t } = useI18n();
</script>

<template>
	<div>
		<Head :title="t('spa.pages.dashboard.label')" />

		<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
			<Welcome />
		</div>
	</div>
</template>
