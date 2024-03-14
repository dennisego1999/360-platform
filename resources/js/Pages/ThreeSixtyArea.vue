<script setup>
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { nextTick, ref } from 'vue';
import Layout from '@/Layouts/Layout.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import VuePannellum from '@/Components/VuePannellum.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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

// Set translation
const { t } = useI18n();

// Set variables
const pannellum = ref(null);
const hotSpots = ref([]);
const activeClickpoint = ref(null);
const isContentVisible = ref(false);

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
	// Set active clickpoint
	activeClickpoint.value = clickpoint;

	// Look at the click point
	pannellum.value.viewer.lookAt(
		clickpoint.coordinates.pitch,
		clickpoint.coordinates.yaw,
		pannellum.value.viewer.hfov,
		1000,
		() => {
			// Open content
			openContent();
		}
	);
}

function createHotSpotIcon(container) {
	container.classList.add('h-5', 'w-5', 'rounded-full', 'bg-green-300', 'hover:opacity-50', 'transition-opacity');
}

function openContent() {
	// Open
	isContentVisible.value = true;
}

function closeContent() {
	// Close
	isContentVisible.value = false;

	// Reset active clickpoint
	activeClickpoint.value = null;
}

nextTick(() => {
	// Set initial history
	setHistory(props.startingViewpoint.id);

	// Init hotspots
	initHotspotsList();
});
</script>

<template>
	<div class="relative flex-1">
		<Modal :show="isContentVisible" @close="closeContent">
			<div class="flex flex-col items-start justify-center gap-2.5">
				<template v-if="activeClickpoint.content_type === 'INFO'">
					<div v-html="activeClickpoint.content.info"></div>
				</template>

				<PrimaryButton @click="closeContent">
					{{ t('spa.buttons.close') }}
				</PrimaryButton>
			</div>
		</Modal>

		<VuePannellum
			v-if="startingViewpoint.image.original_url"
			ref="pannellum"
			class="!absolute h-full w-full"
			:src="startingViewpoint.image.original_url"
			:fade-duration="1200"
			:showFullscreen="false"
			:mouse-zoom="false"
			:double-click-zoom="false"
			:hot-spots="hotSpots"
		/>
	</div>
</template>
