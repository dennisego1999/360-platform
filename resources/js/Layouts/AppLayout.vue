<script setup>
import Navigation from '@/Components/Navigation.vue';
</script>

<template>
	<div class="flex flex-col justify-start items-stretch">
		<navigation />

		<transition name="fade" mode="out-in" appear>
			<slot />
		</transition>
	</div>
</template>
