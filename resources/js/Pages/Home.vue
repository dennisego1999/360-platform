<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

// Define options
defineOptions({
	layout: AppLayout
});

// Define props
defineProps({
	areas: Array
});
</script>

<template>
	<div class="flex justify-center items-center gap-4 flex-1 h-full w-full p-4">
		<PrimaryButton v-for="area in areas" :key="area.id" :href="route('three-sixty-generator', { area: area })">
			{{ area.name }}
		</PrimaryButton>
	</div>
</template>
