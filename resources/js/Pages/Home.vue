<script setup>
import Layout from '@/Layouts/Layout.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

// Define options
defineOptions({
	layout: [Layout, AppLayout]
});
</script>

<template>
	<div class="flex-1 p-4">
		<p>Home</p>
	</div>
</template>
