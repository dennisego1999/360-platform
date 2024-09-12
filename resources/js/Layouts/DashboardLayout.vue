<template>
	<transition name="fade" mode="out-in" appear>
		<div class="relative max-w-screen-xl p-4 sm:p-6 lg:p-8 mx-auto w-full">
			<slot />
		</div>
	</transition>
</template>
