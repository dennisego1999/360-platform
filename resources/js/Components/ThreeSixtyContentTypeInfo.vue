<script setup>
// Define props
defineProps({
	content: String
});
</script>

<template>
	<div class="prose prose-headings:mb-0.5" v-html="content"></div>
</template>
