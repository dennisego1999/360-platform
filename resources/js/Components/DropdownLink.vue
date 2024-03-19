<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
	href: String,
	as: String
});
</script>

<template>
	<div class="relative w-full">
		<button
			v-if="as === 'button'"
			type="submit"
			class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-teal-500 hover:text-white focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
		>
			<slot />
		</button>

		<a
			v-else-if="as === 'a'"
			:href="href"
			class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-teal-500 hover:text-white focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
		>
			<slot />
		</a>

		<Link
			v-else
			:href="href"
			class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-teal-500 hover:text-white focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
		>
			<slot />
		</Link>
	</div>
</template>
