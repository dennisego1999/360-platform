<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Layout from '@/Layouts/Layout.vue';

// Define options
defineOptions({
	layout: [Layout, AppLayout]
});

// Define props
defineProps({
	areas: Array
});
</script>

<template>
	<div class="flex justify-center items-center gap-4 flex-1 w-full">
		<PrimaryButton v-for="area in areas" :key="area.id" :href="route('three-sixty-generator', { area: area })">
			{{ area.name }}
		</PrimaryButton>
	</div>
</template>
