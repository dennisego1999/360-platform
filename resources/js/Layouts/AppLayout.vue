<script setup>
import Navigation from '@/Components/Navigation.vue';
</script>

<template>
	<div class="relative flex flex-col justify-start items-stretch min-h-screen">
		<navigation />

		<transition name="fade" mode="out-in" appear>
			<slot />
		</transition>
	</div>
</template>
