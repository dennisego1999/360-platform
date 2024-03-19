<script setup>
import { usePage, router } from '@inertiajs/vue3';
import { useClearToast, useShowToast } from '@/Composables/Toastification.js';
import { computed, onUnmounted, ref, watch } from 'vue';
import NotificationsOverlay from '@/Components/NotificationsOverlay.vue';
import Navigation from '@/Components/Navigation.vue';

// Set variables
const isNotificationOverlayOpen = ref(false);

// Get the UUID
const flashUuid = computed(() => usePage().props.flash.uuid);

// Define functions
function openNotificationsOverlay() {
	isNotificationOverlayOpen.value = true;
}

function closeNotificationsOverlay() {
	isNotificationOverlayOpen.value = false;
}

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

// Listen for validation errors
onUnmounted(() => {
	router.on('error', (e) => {
		// Retrieve the errors out of the event
		let errors = Object.values(e?.detail?.errors) || [];
		errors = new Set(errors);

		console.log('ERRORRRRRR');

		// Print each error
		errors.forEach((error) => {
			// Set toast id
			const errorId = 'error-toast';

			// Toast
			useClearToast(errorId);
			useShowToast(null, error, 'error', {
				id: errorId
			});
		});
	});
});
</script>

<template>
	<NotificationsOverlay :show="isNotificationOverlayOpen" @close="closeNotificationsOverlay" />

	<main class="relative flex flex-col justify-start items-stretch min-h-screen">
		<Navigation @openNotificationsOverlay="openNotificationsOverlay" />

		<transition name="fade" mode="out-in" appear>
			<slot />
		</transition>
	</main>
</template>
