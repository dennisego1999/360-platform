<script setup>
import { Link, usePage } from '@inertiajs/vue3';
</script>

<template>
	<div class="flex justify-between items-center h-fit w-full p-4 bg-white shadow-lg">
		<div></div>

		<div class="flex justify-end items-center gap-2">
			<Link
				v-for="(item, index) in usePage().props.navigationItems"
				:key="'responsive-menu-item-' + index"
				:href="item.href"
				:method="item.method"
				as="button"
			>
				{{ item.label }}
			</Link>
		</div>
	</div>
</template>
