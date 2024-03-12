<script setup>
import { nextTick, ref } from 'vue';
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
	startingViewpoint: Object,
	startingClickpoints: Array
});

// Set variables
const hotSpots = ref([]);

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

function initHotspotsList() {
	if (props.startingClickpoints.length === 0) {
		return;
	}

	props.startingClickpoints.forEach((clickpoint) => {
		hotSpots.value.push({
			pitch: clickpoint.coordinates.pitch,
			yaw: clickpoint.coordinates.yaw,
			clickHandlerArgs: clickpoint,
			clickHandlerFunc: onHotSpotClick,
			createTooltipFunc: createHotSpotIcon
		});
	});
}

function onHotSpotClick(event, clickpoint) {
	console.log('click', clickpoint);
}

function createHotSpotIcon(container) {
	console.log('creating clickpoint ', container);
}

nextTick(() => {
	// Set initial history
	setHistory(props.startingViewpoint.id);

	// Init hotspots
	initHotspotsList();
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
		:hot-spots="hotSpots"
	/>
</template>
