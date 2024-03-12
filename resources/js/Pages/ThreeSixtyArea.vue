<script setup>
import { nextTick } from 'vue';
import { router } from '@inertiajs/vue3';
import Layout from '@/Layouts/Layout.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import VuePannellum from '@/Components/VuePannellum.vue';

// Define options
defineOptions({
	layout: [Layout, AppLayout]
});

// Define props
const props = defineProps({
	area: Object,
	startingViewpoint: Object
});

// Define functions
function setHistory(viewpointId) {
	router.get(
		route('three-sixty-generator', {
			area: props.area,
			viewpoint: viewpointId
		}),
		{},
		{
			preserveScroll: true,
			preserveState: true
		}
	);
}

nextTick(() => {
	// Set initial history
	setHistory(props.startingViewpoint.id);
});
</script>

<template>
	<VuePannellum
		v-if="startingViewpoint.image.original_url"
		class="flex-1"
		:src="startingViewpoint.image.original_url"
		:fade-duration="1200"
		:showFullscreen="false"
		:mouse-zoom="false"
		:double-click-zoom="false"
	/>
</template>
