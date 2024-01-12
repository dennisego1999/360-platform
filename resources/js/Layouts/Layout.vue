<script setup>
import { computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useClearToast, useShowToast } from '@/Composables/Toastification.js';

// Get the UUID
const flashUuid = computed(() => usePage().props.flash.uuid);

// Handle success messages
watch(
	() => usePage().props?.flash?.success,
	(message) => {
		if (!message || !flashUuid.value) {
			return;
		}

		// Abort if we already had this flashed message
		if (sessionStorage.getItem('flashSuccess') === flashUuid.value) {
			return;
		}

		// Toast the flashed success message
		const successId = 'flash-success-toast';

		useClearToast(successId);
		useShowToast(null, message.toString(), 'success', {
			id: successId
		});

		usePage().props.flash.success = null;
		sessionStorage.setItem('flashSuccess', flashUuid.value);
	},
	{
		immediate: true
	}
);

// Handle error messages
watch(
	() => usePage().props?.flash?.error,
	(message) => {
		if (!message || !flashUuid.value) {
			return;
		}

		// Abort if we already had this flashed message
		if (sessionStorage.getItem('flashError') === flashUuid.value) {
			return;
		}

		// Toast the flashed error
		const error = 'flash-error-toast';

		useClearToast(error);
		useShowToast(null, message.toString(), 'error', {
			id: error
		});

		usePage().props.flash.error = null;
		sessionStorage.setItem('flashError', flashUuid.value);
	},
	{
		immediate: true
	}
);
</script>

<template>
	<slot />
</template>

<style>
.fade-enter-active,
.fade-leave-active {
	transition: opacity 0.4s ease-in-out;
}

.fade-enter-from,
.fade-leave-to {
	opacity: 0;
}
</style>
