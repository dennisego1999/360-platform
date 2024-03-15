<script setup>
import { useI18n } from 'vue-i18n';
import { usePage } from '@inertiajs/vue3';
import { QuillEditor } from '@vueup/vue-quill';
import { computed, nextTick, onMounted, ref, watch } from 'vue';
import useLanguage from '@/Composables/useLanguage.js';
import InputField from '@/Components/InputField.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import ChooseEditingLanguage from '@/Components/ChooseEditingLanguage.vue';
import VuePannellum from '@/Components/VuePannellum.vue';
import Dropdown from '@/Components/Dropdown.vue';

// Define emits
const emit = defineEmits(['update:form', 'ready']);

// Define props
const props = defineProps({
	contentTypes: Array,
	viewpoints: Array,
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

// Get language composable
const { editingLanguage, setEditingLanguage } = useLanguage();

// Define computed variables
const threeSixtyClickpointForm = computed({
	get() {
		return props.form;
	},
	set(value) {
		emit('update:form', value);
	}
});

const filteredViewpoints = computed(() => {
	if (!selectedViewpoint.value) {
		return props.viewpoints;
	}

	return props.viewpoints.filter((viewpoint) => viewpoint !== selectedViewpoint.value);
});

// Set variables
const isLoaded = ref(null);
const pannellum = ref(null);
const selectedContentType = ref(threeSixtyClickpointForm.value.content_type ?? props.contentTypes[0]);
const selectedViewpoint = ref(
	threeSixtyClickpointForm.value.content_type === 'LINK_TO_VIEWPOINT' &&
		threeSixtyClickpointForm.value.content[editingLanguage.value] &&
		threeSixtyClickpointForm.value.content[editingLanguage.value].viewpoint_id
		? getSpecificViewpointFromProps(threeSixtyClickpointForm.value.content[editingLanguage.value].viewpoint_id)
		: null
);
const quillOptions = ref({
	modules: {
		toolbar: [
			[{ header: 1 }],
			[{ header: 2 }],
			[{ list: 'ordered' }],
			[{ list: 'bullet' }],
			[{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }],
			['bold', 'italic', 'underline', 'blockquote', 'link']
		]
	}
});

// Define functions
function initContentObject(reset = false) {
	const locales = usePage().props.locales;

	locales.forEach((locale) => {
		threeSixtyClickpointForm.value.content[locale.code] = {
			info: !reset ? threeSixtyClickpointForm.value.content[locale.code]?.info ?? null : null,
			video: !reset ? threeSixtyClickpointForm.value.content[locale.code]?.video ?? null : null,
			viewpoint_id: !reset ? threeSixtyClickpointForm.value.content[locale.code]?.viewpoint_id ?? null : null,
			inertia_route: !reset ? threeSixtyClickpointForm.value.content[locale.code]?.inertia_route ?? null : null,
			external_url: !reset ? threeSixtyClickpointForm.value.content[locale.code]?.external_url ?? null : null
		};
	});
}

function getSpecificViewpointFromProps(id) {
	return props.viewpoints.find((viewpoint) => viewpoint.id === id);
}

function setupViewerEvents() {
	const viewer = pannellum.value.viewer;

	if (!viewer || !props.canEdit) {
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
	selectedContentType.value = type;
	initContentObject();
}

function selectViewpoint(viewpoint) {
	// Set reactive
	selectedViewpoint.value = viewpoint;
}

function deleteViewpointSelection() {
	selectedViewpoint.value = null;
}

async function setHotSpotProgrammatically(pitch, yaw) {
	await nextTick();

	let viewer = pannellum.value.viewer;
	let oldHotSpot = {
		pitch: pitch,
		yaw: yaw
	};

	oldHotSpot.id = 1;
	oldHotSpot.type = 'info';
	oldHotSpot.text = 'Selected Clickpoint';
	viewer.lookAt(oldHotSpot.pitch, oldHotSpot.yaw);
	viewer.addHotSpot(oldHotSpot);
}

// Expose
defineExpose({ setHotSpotProgrammatically });

// Watch
watch(isLoaded, (value) => {
	if (value) {
		setupViewerEvents();
	}
});

watch(selectedContentType, (value) => {
	// Update form content type
	threeSixtyClickpointForm.value.content_type = value;

	// Reset content object
	initContentObject(true);

	if (value === 'LINK_TO_VIEWPOINT') {
		selectedViewpoint.value = getSpecificViewpointFromProps(
			threeSixtyClickpointForm.value.content[editingLanguage.value].viewpoint_id
		);
	}
});

watch(selectedViewpoint, (value) => {
	threeSixtyClickpointForm.value.content[editingLanguage.value].viewpoint_id = value ? value.id : null;
});

watch(editingLanguage, (newValue, oldValue) => {
	if (newValue !== oldValue && selectedContentType.value === 'LINK_TO_VIEWPOINT') {
		// Update form data
		selectedViewpoint.value = getSpecificViewpointFromProps(
			threeSixtyClickpointForm.value.content[editingLanguage.value].viewpoint_id
		);
	}
});

onMounted(() => {
	// Init form object
	initContentObject();

	// Let parent component is ready
	emit('ready');
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
					<InputError :message="threeSixtyClickpointForm.errors['name.' + editingLanguage]" class="mt-2" />
				</div>

				<div class="sm:col-span-3">
					<InputLabel for="content-type" :value="t('spa.labels.content_type')" />

					<Dropdown
						width="full"
						align="left"
						:disabled="!canEdit"
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
								{{ selectedContentType }}
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

					<div v-if="selectedContentType === 'LINK_TO_VIEWPOINT'">
						<Dropdown
							width="full"
							align="left"
							:disabled="!canEdit"
							:angle="true"
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
								<div v-if="selectedViewpoint">
									{{ selectedViewpoint.name[editingLanguage] }}
								</div>

								<div v-else>
									{{ t('spa.labels.make_selection') }}
								</div>
							</template>

							<template #content>
								<div
									v-for="(viewpoint, index) in filteredViewpoints"
									:key="'viewpoint-' + index"
									class="transition-all hover:bg-gray-50 p-2"
								>
									<div v-if="viewpoint.name[editingLanguage]" @click="selectViewpoint(viewpoint)">
										{{ viewpoint.name[editingLanguage] }}
									</div>

									<p v-else>{{ t('spa.issues.no_translated_viewpoint') }}</p>
								</div>

								<div
									v-if="selectedViewpoint"
									class="transition-colors p-2 hover:bg-red-500 hover:text-white"
									@click="deleteViewpointSelection"
								>
									{{ t('spa.labels.delete_selection') }}
								</div>
							</template>
						</Dropdown>

						<small class="block font-medium text-xs text-gray-700 mt-1">
							{{ t('spa.instructions.viewpoints') }}
						</small>
					</div>

					<div v-if="selectedContentType === 'INERTIA_ROUTE'">
						<InputField
							v-model="threeSixtyClickpointForm.content[editingLanguage].inertia_route"
							type="text"
							name="inertia-route"
							id="inertia-route"
							class="mt-1 block w-full"
							:disabled="!canEdit"
						/>

						<small class="block font-medium text-xs text-gray-700 mt-1">
							{{ t('spa.instructions.inertia_route') }}
						</small>

						<InputError
							:message="threeSixtyClickpointForm.errors['content.' + editingLanguage + '.inertia_route']"
							class="mt-2"
						/>
					</div>

					<div v-if="selectedContentType === 'EXTERNAL_URL'">
						<InputField
							v-model="threeSixtyClickpointForm.content[editingLanguage].external_url"
							type="text"
							name="external-url"
							id="external-url"
							class="mt-1 block w-full"
							:disabled="!canEdit"
						/>

						<small class="block font-medium text-xs text-gray-700 mt-1">
							{{ t('spa.instructions.external_url') }}
						</small>

						<InputError
							:message="threeSixtyClickpointForm.errors['content.' + editingLanguage + '.external_url']"
							class="mt-2"
						/>
					</div>

					<div v-if="selectedContentType === 'VIDEO'">
						<InputField
							v-model="threeSixtyClickpointForm.content[editingLanguage].video"
							type="text"
							name="embedded-video-share-link"
							id="embedded-video-share-link"
							class="mt-1 block w-full"
							:disabled="!canEdit"
						/>

						<small class="block font-medium text-xs text-gray-700 mt-1">
							{{ t('spa.instructions.video') }}
						</small>

						<InputError
							:message="threeSixtyClickpointForm.errors['content.' + editingLanguage + '.video']"
							class="mt-2"
						/>
					</div>

					<div v-if="selectedContentType === 'INFO'">
						<QuillEditor
							v-model:content="threeSixtyClickpointForm.content[editingLanguage].info"
							theme="snow"
							scrollingcontainer="true"
							content-type="html"
							:options="quillOptions"
							:content="threeSixtyClickpointForm.content[editingLanguage].info"
							:read-only="!canEdit"
						/>

						<small class="block font-medium text-xs text-gray-700 mt-1">
							{{ t('spa.instructions.info') }}
						</small>

						<InputError
							:message="threeSixtyClickpointForm.errors['content.' + editingLanguage + '.info']"
							class="mt-2"
						/>
					</div>
				</div>
			</div>
		</div>
	</form>
</template>
