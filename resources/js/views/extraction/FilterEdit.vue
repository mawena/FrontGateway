<!-- eslint-disable vue/no-mutating-props -->
<script setup>
import AppAutocomplete from '@/@core/components/app-form-elements/AppAutocomplete.vue';
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
	lovList: {
		type: Array,
		required: true,
		default: () => ([]),
	},

})

const emit = defineEmits([
	'removeFilter',
])

const localItem = ref(props.data)
const lovList = ref(props.lovList)

const removeFilter = () => {
	emit('removeFilter', props.id)
}
</script>

<template>
	<VCard flat border class="d-flex flex-row">
		<!-- 👉 Left Form -->
		<div class="pa-5 flex-grow-1">
			<VRow>
				<VCol cols="12">
					<VSelect v-model="localItem.type"
						:items="[{ 'id': 'text', 'name': 'Texte' }, { 'id': 'date', 'name': 'Date' }, { 'id': 'lov', 'name': 'Liste de valeurs' }]"
						item-title="name" item-value="id" label="Type" placeholder="Choisir le type" class="mb-3"
						:rules="[requiredValidator]" />
				</VCol>
				<VCol v-if="localItem.type == 'lov'" cols="12">
					<VAutocomplete v-model="localItem.lov_id" :items="lovList" item-title="name" item-value="id"
						label="Liste de valeur" placeholder="Choisir la liste de valeur" class="mb-3" />
				</VCol>
				<VCol cols="12">
					<VTextField v-model="localItem.key" label="Variable" placeholder="Entrez le nom de la variable">
						<template v-slot:prepend-inner>
							:
						</template>
					</VTextField>
				</VCol>
				<VCol cols="12">
					<VTextField v-model="localItem.label" rows="2" label="Texte à afficher"
						placeholder="Entrez le nom du texte à afficher" />
				</VCol>
			</VRow>
		</div>

		<!-- 👉 Item Actions -->
		<div class="d-flex flex-column justify-space-between border-s pa-1">
			<IconBtn @click="removeFilter">
				<VIcon size="20" icon="tabler-x" />
			</IconBtn>
		</div>
	</VCard>
</template>
