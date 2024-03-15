<script setup>
// Define props
defineProps({
	src: String
});
</script>

<template>
	<iframe class="aspect-video w-full" :src="src" />
</template>
