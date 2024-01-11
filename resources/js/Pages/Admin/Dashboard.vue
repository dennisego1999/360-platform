<script setup>
import { Head } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Layout from '@/Layouts/Layout.vue';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import Welcome from '@/Components/Welcome.vue';

// Define options
defineOptions({
	layout: [Layout, DashboardLayout]
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
