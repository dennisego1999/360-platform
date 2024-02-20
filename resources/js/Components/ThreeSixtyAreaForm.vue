<script setup>
import { useI18n } from 'vue-i18n';
import { computed } from 'vue';
import InputField from '@/Components/InputField.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';

// Define emits
const emit = defineEmits(['update:form']);

// Define props
const props = defineProps({
	form: {
		type: Object,
		required: true
	},
	canEdit: {
		type: Boolean,
		default: true
	}
});

// Set translation
const { t } = useI18n();

// Define computed variables
const threeSixtyAreaForm = computed({
	get() {
		return props.form;
	},
	set(value) {
		emit('update:form', value);
	}
});
</script>

<template>
	<form @submit.prevent>
		<div class="flex flex-col gap-8">
			<div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 md:col-span-2">
				<div class="sm:col-span-6">
					<InputLabel for="name" :value="t('spa.labels.name')" />

					<InputField
						v-model="threeSixtyAreaForm.name"
						type="text"
						name="name"
						id="name"
						class="mt-1 block w-full"
						:disabled="!canEdit"
					/>

					<InputError :message="threeSixtyAreaForm.errors.name" class="mt-2" />
				</div>
			</div>
		</div>
	</form>
</template>
