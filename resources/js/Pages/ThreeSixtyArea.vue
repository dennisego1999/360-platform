<script setup>
import { router } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import { computed, nextTick, ref } from 'vue';
import Layout from '@/Layouts/Layout.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import VuePannellum from '@/Components/VuePannellum.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ThreeSixtyContentTypeInfo from '@/Components/ThreeSixtyContentTypeInfo.vue';
import ThreeSixtyContentTypeVideo from '@/Components/ThreeSixtyContentTypeVideo.vue';

// Define options
defineOptions({
	layout: [Layout, AppLayout]
});

// Define props
const props = defineProps({
	area: Object,
	startingViewpointId: Number,
	viewpoints: Array,
	startingClickpoints: Array
});

// Set translation
const { t } = useI18n();

// Set variables
const hfov = ref(105);
const pannellum = ref(null);
const hotSpots = ref([]);
const activeClickpoint = ref(null);
const isContentVisible = ref(false);
const startingPannellumScene = ref(null);
const pannellumSrc = ref({
	default: {
		firstScene: props.startingViewpointId,
		sceneFadeDuration: 1200
	},
	scenes: {}
});

// Set computed variables
const startingViewpoint = computed(() => {
	return props.viewpoints.find((viewpoint) => viewpoint.id === props.startingViewpointId);
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

function initPannellumScenes() {
	props.viewpoints.forEach((viewpoint) => {
		const hotSpotsList = [];

		viewpoint.clickpoints.forEach((clickpoint) => {
			hotSpotsList.push({
				pitch: clickpoint.coordinates.pitch,
				yaw: clickpoint.coordinates.yaw,
				clickHandlerArgs: clickpoint,
				clickHandlerFunc: onHotSpotClick,
				createTooltipFunc: createHotSpotIcon
			});
		});

		pannellumSrc.value.scenes[viewpoint.id] = {
			hfov: hfov.value,
			pitch: parseInt(viewpoint.initial_view.pitch),
			yaw: parseInt(viewpoint.initial_view.yaw),
			type: 'equirectangular',
			panorama: viewpoint.image.original_url,
			hotSpots: hotSpotsList,
			showControls: false
		};
	});

	// Set starting scene
	startingPannellumScene.value = pannellumSrc.value.scenes[props.startingViewpointId];
}

function initPannellumEvents() {
	pannellum.value.viewer.on('load', () => {
		//Get new viewpoint id
		const newViewpointId = pannellum.value.viewer.getScene();

		//Set history
		setHistory(newViewpointId);
	});
}

function onHotSpotClick(event, clickpoint) {
	// Set active clickpoint
	activeClickpoint.value = clickpoint;

	// Look at the click point
	pannellum.value.viewer.lookAt(clickpoint.coordinates.pitch, clickpoint.coordinates.yaw, hfov.value, 1200, () => {
		if (activeClickpoint.value.content_type === 'EXTERNAL_URL') {
			window.open(activeClickpoint.value.content.external_url);

			return;
		}

		if (activeClickpoint.value.content_type === 'INERTIA_ROUTE') {
			router.visit(route(activeClickpoint.value.content.inertia_route));

			return;
		}

		if (activeClickpoint.value.content_type === 'LINK_TO_VIEWPOINT') {
			const targetViewpoint = props.viewpoints.find(
				(viewpoint) => viewpoint.id === clickpoint.content.viewpoint_id
			);

			if (!targetViewpoint) {
				return;
			}

			pannellum.value.viewer.loadScene(
				targetViewpoint.id,
				parseInt(targetViewpoint.initial_view.pitch),
				parseInt(targetViewpoint.initial_view.yaw),
				hfov.value
			);

			return;
		}

		// Open content
		openContent();
	});
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

function handleReady() {
	// Init events
	initPannellumEvents();
}

nextTick(() => {
	// Set initial history
	setHistory(startingViewpoint.value.id);

	// Init scenes
	initPannellumScenes();
});
</script>

<template>
	<div class="relative flex-1">
		<Modal :show="isContentVisible" @close="closeContent">
			<div class="flex flex-col items-start justify-center gap-2.5">
				<ThreeSixtyContentTypeInfo
					v-if="activeClickpoint.content_type === 'INFO'"
					:content="activeClickpoint.content.info"
				/>

				<ThreeSixtyContentTypeVideo
					v-if="activeClickpoint.content_type === 'VIDEO'"
					:src="activeClickpoint.content.video"
				/>

				<PrimaryButton @click="closeContent">
					{{ t('spa.buttons.close') }}
				</PrimaryButton>
			</div>
		</Modal>

		<VuePannellum
			v-if="startingPannellumScene && pannellumSrc"
			ref="pannellum"
			class="!absolute h-full w-full"
			@ready="handleReady"
			:src="pannellumSrc"
			:fade-duration="1200"
			:showFullscreen="false"
			:mouse-zoom="false"
			:double-click-zoom="false"
			:hot-spots="hotSpots"
			:hfov="hfov"
			:yaw="startingPannellumScene.pitch"
			:pitch="startingPannellumScene.yaw"
		/>
	</div>
</template>
