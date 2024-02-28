<script setup>
import 'pannellum';
import 'pannellum/build/pannellum.css';
import _debounce from 'lodash.debounce';
import { computed, nextTick, onBeforeUnmount, ref, watch } from 'vue';

// Define emits
const emit = defineEmits(['load', 'error', 'update:hfov', 'update:yaw', 'update:pitch']);

// Define props
const props = defineProps({
	debug: { type: Boolean, default: false },
	src: { type: [String, Object], required: true },
	preview: { type: String, default: '' },
	autoLoad: { type: Boolean, default: true },
	autoRotate: { type: [Number, Boolean], default: 0 },
	orientation: { type: Boolean, default: false },
	draggable: { type: Boolean, default: true },
	mouseZoom: { type: Boolean, default: true },
	doubleClickZoom: { type: Boolean, default: true },
	showInfo: { type: Boolean, default: false },
	showZoom: { type: Boolean, default: false },
	showFullscreen: { type: Boolean, default: false },
	compass: { type: Boolean, default: false },
	hotSpots: { type: Array, default: () => [] },
	hfov: { type: Number, default: 75 },
	minHfov: { type: Number, default: 30 },
	maxHfov: { type: Number, default: 120 },
	yaw: { type: Number, default: 0 },
	pitch: { type: Number, default: 0 },
	crossOrigin: { type: String, default: 'anonymous' },
	fadeDuration: { type: Number, default: 1000 }
});

// Set variables
let rafId;
const viewer = ref(null);
const container = ref(null);
const info = ref(null);

// Define expose
defineExpose({ viewer });

// Set computed variables
const srcOption = computed(() => {
	if (typeof props.src === 'string') {
		return {
			type: 'equirectangular',
			panorama: props.src,
			hotSpots: props.hotSpots
		};
	}

	if (typeof props.src === 'object') {
		if (props.src.px && props.src.ny) {
			return {
				type: 'cubemap',
				cubeMap: [props.src.pz, props.src.px, props.src.nz, props.src.nx, props.src.py, props.src.ny],
				hotSpots: props.hotSpots
			};
		}

		if (props.src.scenes) {
			return {
				default: props.src.default,
				scenes: props.src.scenes
			};
		}

		console.error('[vue-pannellum] Unknown src type');
		return null;
	}

	console.error('[vue-pannellum] Unknown src type: ' + typeof this.src);
	return null;
});

// Define functions
function load() {
	let options = {
		autoLoad: props.autoLoad,
		autoRotate: props.autoRotate === true ? -2 : 0,
		orientationOnByDefault: props.orientation,
		draggable: props.draggable,
		mouseZoom: props.mouseZoom,
		doubleClickZoom: props.doubleClickZoom,
		compass: props.compass,
		preview: props.preview,
		hfov: props.hfov,
		yaw: props.yaw,
		pitch: props.pitch,
		minHfov: props.minHfov,
		maxHfov: props.maxHfov,
		crossOrigin: props.crossOrigin,
		sceneFadeDuration: props.fadeDuration,
		...srcOption.value
	};
	viewer.value = window.pannellum.viewer(container.value, options);
	viewer.value.on('load', () => {
		emit('load');
	});
	viewer.value.on('error', (err) => {
		emit('error', err);
	});
	if (props.showInfo === false) {
		let el = container.value.querySelector('.pnlm-panorama-info');
		// Note: Using display will not work when in tour mode and switch scene
		if (el) el.style.visibility = 'hidden';
	}
	if (props.showZoom === false) {
		let el = container.value.querySelector('.pnlm-zoom-controls');
		if (el) el.style.display = 'none';
	}
	if (props.showFullscreen === false) {
		let el = container.value.querySelector('.pnlm-fullscreen-toggle-button');
		if (el) el.style.display = 'none';
	}
}

function loop() {
	rafId = window.requestAnimationFrame(loop);
	let hfov = viewer.value.getHfov();
	let yaw = viewer.value.getYaw();
	let pitch = viewer.value.getPitch();
	if (pitch > 90) pitch = 90;
	else if (pitch < -90) pitch = -90;
	if (hfov !== props.hfov) emit('update:hfov', hfov);
	if (yaw !== props.yaw) emit('update:yaw', yaw);
	if (pitch !== props.pitch) emit('update:pitch', pitch);
}

function onMouseUp() {
	if (props.debug) info.value += ' mu';
	debounceRotate();
	viewer.value.getYaw();
	viewer.value.getPitch();
	window.pannellum.viewer.yaw = viewer.value.getYaw();
	window.pannellum.viewer.pitch = viewer.value.getPitch();
}

function onTouchMove() {
	if (props.debug) info.value += ' tm';
}

function onTouchEnd() {
	if (props.debug) info.value += ' te';
	debounceRotate();
}

const debounceRotate = _debounce(function () {
	// priority of orientation is higher
	if (props.orientation) viewer.value.startOrientation();
	else if (props.autoRotate) viewer.value.startAutoRotate();
}, 3000);

// Watch
watch(
	() => props.src,
	() => {
		container.value.innerHTML = '';
		nextTick(() => {
			console.log('load watcher');
			load();
		});
	}
);

watch(
	() => props.hfov,
	(value) => {
		if (viewer.value) {
			viewer.value.setHfov(value, false);
		}
	}
);

watch(
	() => props.yaw,
	(value) => {
		if (viewer.value) {
			viewer.value.setYaw(value, false);
		}
	}
);

watch(
	() => props.pitch,
	(value) => {
		if (viewer.value) {
			viewer.value.setPitch(value, false);
		}
	}
);

watch(
	() => props.maxHfov,
	() => {
		if (viewer.value) {
			viewer.value.setHfovBounds([props.minHfov, props.maxHfov]);
		}
	}
);

watch(
	() => props.minHfov,
	() => {
		if (viewer.value) {
			viewer.value.viewer.setHfovBounds([props.minHfov, props.maxHfov]);
		}
	}
);

watch(
	() => props.autoRotate,
	(value) => {
		if (value) {
			viewer.value.startAutoRotate();
			return;
		}

		viewer.value.stopAutoRotate();
		if (props.orientation) viewer.value.startOrientation();
	}
);

watch(
	() => props.orientation,
	(value) => {
		if (value) {
			viewer.value.startOrientation();
			return;
		}

		viewer.value.stopOrientation();
		if (props.autoRotate) viewer.value.startAutoRotate();
	}
);

nextTick(() => {
	// Load
	load();

	// Start loop
	loop();
});

onBeforeUnmount(() => {
	viewer.value.destroy();
	window.cancelAnimationFrame(rafId);
});
</script>

<template>
	<div class="vue-pannellum" @mouseup="onMouseUp" @touchmove="onTouchMove" @touchend="onTouchEnd">
		<div ref="container">
			<div class="info">{{ info }}</div>

			<div class="default-slot">
				<slot />
			</div>
		</div>
	</div>
</template>

<style lang="scss">
.vue-pannellum {
	position: relative;
}

.info {
	position: absolute;
	background-color: hsla(0, 0%, 100%, 0.5);
	top: 0;
	left: 0;
	width: 100%;
	z-index: 2;
}

.default-slot {
	position: absolute;
	left: 0;
	bottom: 0;
}

.pnlm-ui {
	.pnlm-about-msg,
	.pnlm-orientation-button {
		display: none !important;
	}
}
</style>
