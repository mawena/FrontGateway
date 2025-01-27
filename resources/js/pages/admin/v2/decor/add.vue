<!-- eslint-disable camelcase -->
<script setup>
definePage({
	meta: {
		action: 'create',
		subject: 'event',
	},
})
import { ref } from 'vue'
import { VTextarea } from 'vuetify/lib/components/index.mjs'

const router = useRouter()

const itemData = ref({
	name: null,
	start_date: null,
	end_date: null,
	place: null,
	type: null,
	nb_expected: null,
	entrance: null,
	entry_price: 0,
	contact: null,
	description_summary: null,
	description: null,
	poster: null,
})

const getResetTransferError = () => {
	return {
		name: "",
		start_date: "",
		end_date: "",
		place: "",
		type: "",
		nb_expected: "",
		entrance: "",
		entry_price: "",
		contact: "",
		description_summary: "",
		description: "",
		poster: "",
	}
}
const itemError = ref(getResetTransferError())
const refForm = ref()

const changeFile = file => {
	const fileReader = new FileReader()
	const { files } = file.target
	if (files && files.length) {
		fileReader.readAsDataURL(files[0])
		fileReader.onload = () => {
			if (typeof fileReader.result === 'string') {
				itemData.value.poster = fileReader.result
			}
		}
	}
}

const onSubmit = () => {
	refForm.value?.validate().then(async ({ valid }) => {
		if (valid) {
			const res = await $api('/event', {
				method: 'POST',
				body: {
					name: itemData.value.name,
					start_date: itemData.value.start_date,
					end_date: itemData.value.end_date,
					place: itemData.value.place,
					type: itemData.value.type,
					nb_expected: itemData.value.nb_expected,
					entrance: itemData.value.entrance,
					entry_price: itemData.value.entry_price,
					contact: itemData.value.contact,
					description_summary: itemData.value.description_summary,
					description: itemData.value.description,
					poster: itemData.value.poster,
				},
			})

			itemError.value = getResetTransferError()
			if (res.status == 201) {
				snackbarMessage.value = "Evenement crée"
				snackbarCollor.value = "success"
				isSnackbarScrollReverseVisible.value = true
				router.push({name: 'admin-v2-event'})
			} else {
				if (res.errors.poster) {
					itemError.value["poster"] = res.errors.poster
					res.errors.poster = null
				}
				if (res.errors.name) {
					itemError.value["name"] = res.errors.name
					res.errors.name = null
				}
				if (res.errors.start_date) {
					itemError.value["start_date"] = res.errors.start_date
					res.errors.start_date = null
				}
				if (res.errors.end_date) {
					itemError.value["end_date"] = res.errors.end_date
					res.errors.end_date = null
				}
				if (res.errors.place) {
					itemError.value["place"] = res.errors.place
					res.errors.place = null
				}
				if (res.errors.type) {
					itemError.value["type"] = res.errors.type
					res.errors.type = null
				}
				if (res.errors.nb_expected) {
					itemError.value["nb_expected"] = res.errors.nb_expected
					res.errors.nb_expected = null
				}
				if (res.errors.entrance) {
					itemError.value["entrance"] = res.errors.entrance
					res.errors.entrance = null
				}
				if (res.errors.entry_price) {
					itemError.value["entry_price"] = res.errors.entry_price
					res.errors.entry_price = null
				}
				if (res.errors.contact) {
					itemError.value["contact"] = res.errors.contact
					res.errors.contact = null
				}
				if (res.errors.description_summary) {
					itemError.value["description_summary"] = res.errors.description_summary
					res.errors.description_summary = null
				}
				if (res.errors.description) {
					itemError.value["description"] = res.errors.description
					res.errors.description = null
				}
				snackbarMessage.value = ""
				let show = false
				for (const key in res.errors) {
					if (res.errors[key] != null) {
						show = true;
						snackbarCollor.value = "error"
						snackbarMessage.value += res.errors[key] + "<br>";
					}
				}
				isSnackbarScrollReverseVisible.value = show
			}
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
const localUserData = useCookie('userData').value
</script>

<template>
	<div>
		<div class="d-flex flex-wrap justify-start justify-sm-space-between gap-y-4 gap-x-6 mb-6">
			<div class="d-flex flex-column justify-center">
				<h4 class="text-h4 font-weight-medium">
					Ajouter un Evenement
				</h4>
				<span>Informations sur l'evenement</span>
			</div>
		</div>
		<VForm ref="refForm" @submit.prevent="onSubmit">
			<VRow>
				<VCol md="12">
					<!-- 👉 PV Information -->
					<VCard class="mb-6" title="Informations de l'Evenement">
						<VCardText>
							<VRow>
								<VCol cols="12" md="12" lg="2">
									<VFileInput accept=".png,.jpg,.jpeg,.webp" label="Poster" :error-messages="itemError.file" @input="changeFile" required />
								</VCol>
								<VCol cols="12" md="12" lg="10">
									<VTextField v-model="itemData.name" :error-messages="itemError.name" label="Nom" />
								</VCol>
								<VCol cols="12" md="12" lg="6">
									<AppDateTimePicker v-model="itemData.start_date" :error-messages="itemError.start_date" label="Date de debut" />
								</VCol>
								<VCol cols="12" md="12" lg="6">
									<AppDateTimePicker v-model="itemData.end_date" :error-messages="itemError.end_date" label="Date de fin" />
								</VCol>
								<VCol cols="12" md="12" lg="4">
									<VTextField v-model="itemData.place" :error-messages="itemError.place" label="Lieu" />
								</VCol>
								<VCol cols="12" md="12" lg="4">
									<VTextField v-model="itemData.type" :error-messages="itemError.type" label="Type" />
								</VCol>
								<VCol cols="12" md="12" lg="4">
									<VTextField v-model="itemData.nb_expected" :error-messages="itemError.nb_expected" label="Nombre de personnes attendus" type="number" />
								</VCol>
								<VCol cols="12" md="12" lg="12">
									<VAutocomplete v-model="itemData.entrance" :error-messages="itemError.entrance" label="Entrée" :items="[{'key': 'paid', 'name': 'Payante'}, {'key': 'free', 'name': 'Gratuite'}]" item-title="name" item-value="key"/>
								</VCol>
								<VCol cols="12" md="12" lg="12" v-if="itemData.entrance == 'paid'">
									<VTextField v-model="itemData.entry_price" :error-messages="itemError.entry_price" label="Prix d'entrée" type="number" />
								</VCol>
								<VCol cols="12" md="12" lg="8">
									<VTextField v-model="itemData.description_summary" :error-messages="itemError.description_summary" label="Description résumé" />
								</VCol>
								<VCol cols="12" md="12" lg="4">
									<VTextField v-model="itemData.contact" :error-messages="itemError.contact" label="Contact" />
								</VCol>
								<VCol cols="12" md="12" lg="12">
									<VTextarea v-model="itemData.description" :error-messages="itemError.description" label="Description Detaillé" />
								</VCol>
							</VRow>
						</VCardText>
					</VCard>
				</VCol>
				<VCol cols="12">
					<div class="d-flex flex-wrap justify-start justify-sm-space-between gap-y-4 gap-x-6 mb-6">
						<div class="d-flex flex-column justify-center">
								<VBtn :to="{ name: 'admin-v2-event' }">
									Evenements
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
