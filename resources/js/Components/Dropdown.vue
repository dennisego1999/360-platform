<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';
import AngleDownIcon from '@/Components/AngleDownIcon.vue';

const props = defineProps({
	disabled: {
		type: Boolean,
		default: false
	},
	angle: {
		type: Boolean,
		default: false
	},
	align: {
		type: String,
		default: 'right'
	},
	width: {
		type: String,
		default: '48'
	},
	containerClasses: Array,
	contentClasses: {
		type: Array,
		default: () => ['bg-white']
	}
});

let open = ref(false);

const closeOnEscape = (e) => {
	if (open.value && e.key === 'Escape') {
		open.value = false;
	}
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const widthClass = computed(() => {
	return {
		full: 'w-full',
		fit: 'w-fit',
		48: 'w-48'
	}[props.width.toString()];
});

const alignmentClasses = computed(() => {
	if (props.align === 'left') {
		return 'ltr:origin-top-left rtl:origin-top-right start-0';
	}

	if (props.align === 'right') {
		return 'ltr:origin-top-right rtl:origin-top-left end-0';
	}

	return 'origin-top';
});

function toggleOpenState() {
	if (props.disabled) {
		return;
	}

	open.value = !open.value;
}

function close() {
	open.value = false;
}
</script>

<template>
	<div class="relative" :class="containerClasses">
		<div @click="toggleOpenState" :class="{ 'cursor-pointer': !disabled }">
			<slot v-if="!angle" name="trigger" />

			<div v-else class="flex justify-between items-center gap-1">
				<slot name="trigger" />

				<AngleDownIcon
					v-if="!disabled"
					class="h-4 w-4 transition-transform fill-white"
					:class="{ 'rotate-180': open, 'rotate-0': !open }"
				/>
			</div>
		</div>

		<!-- Full Screen Dropdown Overlay -->
		<div v-show="open" class="fixed inset-0 z-40" @click="close" />

		<transition
			enter-active-class="transition ease-out duration-200"
			enter-from-class="transform opacity-0 scale-95"
			enter-to-class="transform opacity-100 scale-100"
			leave-active-class="transition ease-in duration-75"
			leave-from-class="transform opacity-100 scale-100"
			leave-to-class="transform opacity-0 scale-95"
		>
			<div
				v-show="open"
				class="absolute z-50 mt-3 rounded-md shadow-xl"
				:class="[widthClass, alignmentClasses]"
				style="display: none"
				@click="close"
			>
				<div
					class="overflow-hidden rounded-md ring-1 ring-black ring-opacity-5 cursor-pointer text-gray-800"
					:class="contentClasses"
				>
					<slot name="content" />
				</div>
			</div>
		</transition>
	</div>
</template>
