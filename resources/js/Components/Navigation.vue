<script setup>
import { Link, usePage } from '@inertiajs/vue3';
</script>

<template>
	<div class="flex justify-between items-center h-fit w-full p-4 bg-white shadow-lg">
		<div></div>

		<div class="flex justify-end items-center gap-2">
			<template v-if="!usePage().props.auth.user">
				<Link :href="route('login')"> Login </Link>
				<Link :href="route('register')"> Register </Link>
			</template>

			<template v-else>
				<Link v-if="usePage().props.policies.can.accessDashboard" :href="route('admin.dashboard')">
					Dashboard
				</Link>

				<Link v-else :href="route('profile.show')">Profile</Link>
			</template>
		</div>
	</div>
</template>
