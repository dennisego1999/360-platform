<script setup>
import { useI18n } from 'vue-i18n';
import { Link, usePage } from '@inertiajs/vue3';
import { BellIcon } from '@heroicons/vue/16/solid';
import LanguageSwitcher from '@/Components/LanguageSwitcher.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

// Define emits
const emit = defineEmits(['open-notifications-overlay']);

// Set translation
const { t } = useI18n();

// Define functions
function openNotificationsOverlay() {
	emit('open-notifications-overlay');
}
</script>

<template>
	<div
		class="flex items-center w-full p-4 bg-indigo-500 text-white font-bold"
		:class="{
			'justify-between': !usePage().props.is_dashboard,
			'justify-start gap-8': usePage().props.is_dashboard
		}"
	>
		<Link :href="route('home')">
			<ApplicationLogo class="block h-8 w-auto fill-white" />
		</Link>

		<div v-if="!usePage().props.is_dashboard" class="flex justify-between items-center gap-4">
			<div v-if="usePage().props.auth.user" class="flex justify-between items-center gap-4">
				<BellIcon class="cursor-pointer w-4" @click="openNotificationsOverlay" />

				<Dropdown align="right" width="48">
					<template #trigger>
						<button class="flex text-sm border-2 border-white rounded-full transition">
							<img
								v-if="usePage().props.auth.user"
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

							<DropdownLink :href="route('profile.show')" method="post">
								{{ t('spa.pages.profile.label') }}
							</DropdownLink>

							<DropdownLink :href="route('logout')" method="post">
								{{ t('spa.pages.users.logout') }}
							</DropdownLink>
						</div>
					</template>
				</Dropdown>
			</div>

			<div v-else class="flex justify-end items-center gap-4">
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

		<div v-else class="flex justify-between items-center gap-4 flex-1">
			<div class="flex justify-end items-center gap-4">
				<Link
					v-for="(item, index) in usePage().props.navigationItems"
					:key="'responsive-menu-item-' + index"
					:href="item.href"
					:method="item.method"
					as="button"
					class="text-white text-sm"
				>
					{{ item.label }}
				</Link>
			</div>

			<div class="flex justify-between items-center gap-4">
				<Dropdown v-if="usePage().props.auth.user" align="right" width="48">
					<template #trigger>
						<button class="flex text-sm border-2 border-white rounded-full transition">
							<img
								v-if="usePage().props.auth.user"
								class="h-8 w-8 rounded-full object-cover"
								:src="usePage().props.auth.user.profile_photo_url"
								:alt="usePage().props.auth.user.name"
							/>
						</button>
					</template>

					<template #content>
						<div class="flex flex-col justify-center items-start">
							<DropdownLink :href="route('profile.show')" method="post">
								{{ t('spa.pages.profile.label') }}
							</DropdownLink>

							<DropdownLink :href="route('logout')" method="post">
								{{ t('spa.pages.users.logout') }}
							</DropdownLink>
						</div>
					</template>
				</Dropdown>

				<language-switcher />
			</div>
		</div>
	</div>
</template>
