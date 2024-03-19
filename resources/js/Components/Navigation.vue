<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import LanguageSwitcher from '@/Components/LanguageSwitcher.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
</script>

<template>
	<div class="flex justify-between items-center w-full p-4 bg-gray-100">
		<Link :href="route('home')">LOGO</Link>

		<div class="flex justify-between items-center gap-4">
			<Dropdown v-if="usePage().props.auth.user" align="right" width="48">
				<template #trigger>
					<button
						class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition"
					>
						<img
							class="h-8 w-8 rounded-full object-cover"
							:src="usePage().props.auth.user.profile_photo_url"
							:alt="usePage().props.auth.user.name"
						/>
					</button>
				</template>

				<template #content>
					<div class="flex flex-col justify-center items-start">
						<DropdownLink
							v-for="(item, index) in usePage().props.navigationItems"
							:key="'responsive-menu-item-' + index"
							:href="item.href"
							:method="item.method"
						>
							{{ item.label }}
						</DropdownLink>
					</div>
				</template>
			</Dropdown>

			<div v-else class="flex justify-end items-center gap-8">
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

			<language-switcher />
		</div>
	</div>
</template>
