<!-- eslint-disable vue/no-mutating-props -->
<script setup>
import AppTextField from '@/@core/components/app-form-elements/AppTextField.vue';

const props = defineProps({
	id: {
		type: Number,
		required: true,
	},
	data: {
		type: Object,
		required: true,
		default: () => ({
			key: null,
			label: null,
			type: null,
		}),
	},
})

const emit = defineEmits([
	'removeValue',
])

const localItem = ref(props.data)

const removeValue = () => {
	emit('removeValue', props.id)
}
</script>

<template>
	<VCard flat border class="d-flex flex-row">
		<!-- 👉 Left Form -->
		<div class="pa-5 flex-grow-1">
			<VRow>
				<VCol cols="12">
					<VTextarea v-model="localItem.label" rows="2" label="Texte à afficher"
						placeholder="Entrez le nom du texte à afficher" />
				</VCol>
			</VRow>
			<VRow>
				<VCol cols="12">
					<VTextarea v-model="localItem.value" rows="2" label="Valeur"
						placeholder="Entrez la valeur" />
				</VCol>
			</VRow>
		</div>

		<!-- 👉 Item Actions -->
		<div class="d-flex flex-column justify-space-between border-s pa-1">
			<IconBtn @click="removeValue">
				<VIcon size="20" icon="tabler-x" />
			</IconBtn>
		</div>
	</VCard>
</template>
