<template>
	<transition name="fade" mode="out-in" appear>
		<div class="max-w-7xl sm:p-6 lg:p-8">
			<slot />
		</div>
	</transition>
</template>
<script setup></script>
