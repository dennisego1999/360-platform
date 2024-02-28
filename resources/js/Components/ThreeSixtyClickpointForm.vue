<script setup>
import { useI18n } from 'vue-i18n';
import { computed, ref, watch } from 'vue';
import useLanguage from '@/Composables/useLanguage.js';
import InputField from '@/Components/InputField.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ChooseEditingLanguage from '@/Components/ChooseEditingLanguage.vue';
import VuePannellum from '@/Components/VuePannellum.vue';
import Dropdown from '@/Components/Dropdown.vue';

// Define emits
const emit = defineEmits(['update:form']);

// Define props
const props = defineProps({
	contentTypes: Array,
	src: String,
	form: {
		type: Object,
		required: true
	},
	canEdit: {
		type: Boolean,
		default: true
	}
});

// Set translation
const { t } = useI18n();

// Set variables
const isLoaded = ref(null);
const pannellum = ref(null);

// Define computed variables
const threeSixtyClickpointForm = computed({
	get() {
		return props.form;
	},
	set(value) {
		emit('update:form', value);
	}
});

// Get language composable
const { editingLanguage, setEditingLanguage } = useLanguage();

// Define functions
function setupViewerEvents() {
	const viewer = pannellum.value.viewer;

	if (!viewer) {
		return;
	}

	let mouseStart;

	viewer.on('mousedown', (event) => {
		mouseStart = {
			screenX: event.screenX,
			screenY: event.screenY
		};
	});

	viewer.on('mouseup', (event) => {
		// coords[0] is pitch, coords[1] is yaw
		// abort hotspot creation when mouse was moved more than 10px in either direction
		// since that means we dragged
		if (Math.abs(event.screenX - mouseStart.screenX) > 10 || Math.abs(event.screenY - mouseStart.screenY) > 10) {
			return;
		}

		viewer.removeHotSpot(1);
		let coords = viewer.mouseEventToCoords(event);

		viewer.addHotSpot({
			id: 1,
			pitch: coords[0],
			yaw: coords[1],
			type: 'info',
			text: 'Selected Clickpoint'
		});

		threeSixtyClickpointForm.value.coordinates = {
			pitch: coords[0],
			yaw: coords[1]
		};
	});
}

function selectContentType(type) {
	threeSixtyClickpointForm.value.content_type = type;
}

// Watch
watch(isLoaded, (value) => {
	if (value) {
		setupViewerEvents();
	}
});
</script>

<template>
	<form @submit.prevent>
		<div class="flex flex-col gap-8">
			<div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
				<div class="sm:col-span-6">
					<ChooseEditingLanguage @language="setEditingLanguage" />
				</div>

				<div class="sm:col-span-3">
					<InputLabel for="name" :value="t('spa.labels.name')" />

					<InputField
						v-model="threeSixtyClickpointForm.name[editingLanguage]"
						type="text"
						name="name"
						id="name"
						class="mt-1 block w-full"
						:disabled="!canEdit"
					/>

					<InputError :message="threeSixtyClickpointForm.errors.name" class="mt-2" />
				</div>

				<div class="sm:col-span-3">
					<InputLabel for="content-type" :value="t('spa.labels.content_type')" />

					<Dropdown
						width="full"
						align="left"
						:angle="contentTypes.length > 1"
						:container-classes="[
							'bg-white',
							'p-2',
							'border-gray-300',
							'focus:border-indigo-500',
							'focus:ring-indigo-500',
							'rounded-md',
							'shadow-sm',
							'mt-1',
							'block',
							'w-full'
						]"
					>
						<template #trigger>
							<div>
								{{ threeSixtyClickpointForm.content_type }}
							</div>
						</template>

						<template #content>
							<div
								v-for="(type, index) in contentTypes"
								:key="'content-type-' + index"
								class="transition-all hover:bg-gray-50 p-2"
								@click="selectContentType(type)"
							>
								{{ type }}
							</div>
						</template>
					</Dropdown>

					<InputError :message="threeSixtyClickpointForm.errors.content_type" class="mt-2" />
				</div>

				<div class="sm:col-span-3">
					<InputLabel for="name" :value="t('spa.labels.coordinates')" />

					<Transition name="fade" mode="out-in">
						<div
							v-if="
								threeSixtyClickpointForm.coordinates.pitch && threeSixtyClickpointForm.coordinates.yaw
							"
							class="flex justify-start items-center gap-2 my-4 w-fit"
						>
							<div class="flex justify-between items-center gap-2 p-2 bg-white rounded-md shadow-sm">
								<strong>Pitch:</strong>
								<p>{{ threeSixtyClickpointForm.coordinates.pitch.toFixed(3) }}</p>
							</div>

							<div class="flex justify-between items-center gap-2 p-2 bg-white rounded-md shadow-sm">
								<strong>Yaw:</strong>
								<p>{{ threeSixtyClickpointForm.coordinates.yaw.toFixed(3) }}</p>
							</div>
						</div>
					</Transition>

					<VuePannellum
						:showFullscreen="false"
						:src="src"
						@load="isLoaded = true"
						ref="pannellum"
						class="aspect-video"
						:class="{
							'mt-2': !(
								threeSixtyClickpointForm.coordinates.pitch && threeSixtyClickpointForm.coordinates.yaw
							)
						}"
					/>

					<InputError :message="threeSixtyClickpointForm.errors.coordinates" class="mt-2" />
				</div>

				<div class="sm:col-span-3">
					<InputLabel for="content" :value="t('spa.labels.content')" />

					<InputError :message="threeSixtyClickpointForm.errors.content" class="mt-2" />
				</div>
			</div>
		</div>
	</form>
</template>
