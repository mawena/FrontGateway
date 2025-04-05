<!-- eslint-disable camelcase -->
<script setup>
definePage({
	meta: {
		action: 'create',
		subject: 'product',
	},
})
import { ref } from 'vue'
import { useAxios } from '@vueuse/integrations/useAxios'

const router = useRouter()
const nextRoute = { name: 'product' }
const itemData = ref({
	nom: "",
	prix: "",
})


const getResetTransferError = () => {
	return {
		nom: "",
		prix: "",
	}
}
const itemError = ref(getResetTransferError())


const refForm = ref()

const onSubmit = () => {
	refForm.value?.validate().then(async ({ valid }) => {
		if (valid) {
			const { response, data, error } = await useAxios(`/api/GATEWAY/SERVICE-PRODUIT/produits`, {
				method: 'POST',
				data: {
					nom: itemData.value.nom,
					prix: itemData.value.prix,
				},
			})

			console.log("storeData", data);

			if (response.value) {
				if (response.value.status == 200) {
					console.log('Statut HTTP:', response.value.status) // ex: 200
					router.push(nextRoute)
				}
				console.log('Statut HTTP:', response.value.status) // ex: 200
			} else if (error.value) {
				console.error('Erreur:', error.value)
			}
			snackbarMessage.value = "Insertion effectuée avec succès";
			isSnackbarScrollReverseVisible.value = true;
			nextTick(() => {
				// refForm.value?.reset()
				refForm.value?.resetValidation()
			})
		}
	})
}

const isSnackbarScrollReverseVisible = ref(false)
const snackbarMessage = ref("")
const snackbarCollor = ref("success")
const isPasswordVisible = ref(false)

const localUserData = useCookie('userData').value
</script>

<template>
	<div>
		<div class="d-flex flex-wrap justify-start justify-sm-space-between gap-y-4 gap-x-6 mb-6">
			<div class="d-flex flex-column justify-center">
				<h4 class="text-h4 font-weight-medium">
					Ajouter un produit
				</h4>
				<span>Informations sur le produit</span>
			</div>
		</div>
		<VForm ref="refForm" @submit.prevent="onSubmit">
			<VRow>
				<VCol md="12">
					<!-- 👉 PV Information -->
					<VCard class="mb-6" title="Informations du produit">
						<VCardText>
							<VRow>
								<VCol cols="12" md="12" lg="12">
									<VTextField v-model="itemData.nom" label="Nom" />
								</VCol>
								<VCol cols="12" md="12" lg="12">
									<VTextField type="number" v-model="itemData.prix" label="Prix" />
								</VCol>
							</VRow>
						</VCardText>
					</VCard>
				</VCol>
				<VCol cols="12">
					<div class="d-flex flex-wrap justify-start justify-sm-space-between gap-y-4 gap-x-6 mb-6">
						<div class="d-flex flex-column justify-center">
							<VBtn :to="{ name: 'product' }">
								Produits
							</VBtn>
						</div>
						<div class="d-flex gap-4 align-center flex-wrap">
							<VBtn type="reset" variant="tonal" color="primary">
								<VIcon start icon="tabler-circle-minus" />
								Effacer
							</VBtn>
							<VBtn type="submit" class="me-3">
								Enregistrer
								<VIcon end icon="tabler-checkbox" />
							</VBtn>
						</div>
					</div>
				</VCol>
			</VRow>
		</VForm>

		<VSnackbar v-model="isSnackbarScrollReverseVisible" transition="scale-transition" location="top end"
			:color="snackbarCollor">
			<div v-html="snackbarMessage"></div>
		</VSnackbar>
	</div>
</template>

<style lang="scss" scoped>
.drop-zone {
	border: 2px dashed rgba(var(--v-theme-on-surface), 0.12);
	border-radius: 6px;
}
</style>

<style lang="scss">
.inventory-card {

	.v-radio-group,
	.v-checkbox {
		.v-selection-control {
			align-items: start !important;

			.v-selection-control__wrapper {
				margin-block-start: -0.375rem !important;
			}
		}

		.v-label.custom-input {
			border: none !important;
		}
	}

	.v-tabs.v-tabs-pill {
		.v-slide-group-item--active.v-tab--selected.text-primary {
			h6 {
				color: #fff !important
			}
		}
	}

}

.ProseMirror {
	p {
		margin-block-end: 0;
	}

	padding: 0.5rem;
	outline: none;

	p.is-editor-empty:first-child::before {
		block-size: 0;
		color: #adb5bd;
		content: attr(data-placeholder);
		float: inline-start;
		pointer-events: none;
	}
}
</style>
