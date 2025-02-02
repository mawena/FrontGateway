<!-- eslint-disable camelcase -->
<script setup>
definePage({
	meta: {
		action: 'create',
		subject: 'decor',
	},
})
import { ref } from 'vue'
import { VTextarea } from 'vuetify/lib/components/index.mjs'

const router = useRouter()

const itemData = ref({
	event_id: null,
	name: null,
	start_use: null,
	end_use: null,
	file: null,
})

const getResetTransferError = () => {
	return {
		event_id: "",
		name: "",
		start_use: "",
		end_use: "",
		file: "",
	}
}
const itemError = ref(getResetTransferError())
const refForm = ref()
const localUserData = useCookie('userData').value
const userIdFilter = localUserData.role == "promoter" ? localUserData.id : null

const { data: eventListData } = await useApi(
	createUrl(`/event`, {
		query: {
			paginate: "false",
			user_id: userIdFilter
		},
	})
);
const eventList = computed(() => eventListData.value.data);

const changeFile = file => {
	const fileReader = new FileReader()
	const { files } = file.target
	if (files && files.length) {
		fileReader.readAsDataURL(files[0])
		fileReader.onload = () => {
			if (typeof fileReader.result === 'string') {
				itemData.value.file = fileReader.result
			}
		}
	}
}

const onSubmit = () => {
	refForm.value?.validate().then(async ({ valid }) => {
		if (valid) {
			const res = await $api('/decor', {
				method: 'POST',
				body: {
					event_id: itemData.value.event_id,
					name: itemData.value.name,
					start_use: itemData.value.start_use,
					end_use: itemData.value.end_use,
					file: itemData.value.file,
				},
			})

			itemError.value = getResetTransferError()
			if (res.status == 201) {
				snackbarMessage.value = "Decor crée"
				snackbarCollor.value = "success"
				isSnackbarScrollReverseVisible.value = true
				router.push({ name: 'admin-v2-decor' })
			} else {
				if (res.errors.event_id) {
					itemError.value["event_id"] = res.errors.event_id
					res.errors.event_id = null
				}
				if (res.errors.name) {
					itemError.value["name"] = res.errors.name
					res.errors.name = null
				}
				if (res.errors.start_use) {
					itemError.value["start_use"] = res.errors.start_use
					res.errors.start_use = null
				}
				if (res.errors.end_use) {
					itemError.value["end_use"] = res.errors.end_use
					res.errors.end_use = null
				}
				if (res.errors.file) {
					itemError.value["file"] = res.errors.file
					res.errors.file = null
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
</script>

<template>
	<div>
		<div class="d-flex flex-wrap justify-start justify-sm-space-between gap-y-4 gap-x-6 mb-6">
			<div class="d-flex flex-column justify-center">
				<h4 class="text-h4 font-weight-medium">
					Ajouter un Decor
				</h4>
				<span>Informations sur le décor</span>
			</div>
		</div>
		<VForm ref="refForm" @submit.prevent="onSubmit">
			<VRow>
				<VCol md="12">
					<!-- 👉 PV Information -->
					<VCard class="mb-6" title="Informations du Decor">
						<VCardText>
							<VRow>
								<VCol cols="12" md="12" lg="2">
									<VFileInput accept=".png,.jpg,.jpeg,.webp" label="Decor"
										:error-messages="itemError.file" @input="changeFile" required />
								</VCol>
								<VCol cols="12" md="12" lg="5">
									<VAutocomplete v-model="itemData.event_id" :error-messages="itemError.event_id"
										label="Evenement" :items="eventList" item-title="name" item-value="id"
										clearable />
								</VCol>
								<VCol cols="12" md="12" lg="5">
									<VTextField v-model="itemData.name" :error-messages="itemError.name" label="Nom"
										required />
								</VCol>
								<VCol cols="12" md="12" lg="6">
									<AppDateTimePicker v-model="itemData.start_use"
										:error-messages="itemError.start_use" label="Date de début" required />
								</VCol>
								<VCol cols="12" md="12" lg="6">
									<AppDateTimePicker v-model="itemData.end_use" :error-messages="itemError.end_use"
										label="Date de fin" />
								</VCol>
							</VRow>
						</VCardText>
					</VCard>
				</VCol>
				<VCol cols="12">
					<div class="d-flex flex-wrap justify-start justify-sm-space-between gap-y-4 gap-x-6 mb-6">
						<div class="d-flex flex-column justify-center">
							<VBtn :to="{ name: 'admin-v2-decor' }">
								Liste des décors
							</VBtn>
						</div>
						<div class="d-flex gap-4 align-center flex-wrap">
							<VBtn type="reset" variant="tonal" color="primary">
								<VIcon start icon="tabler-circle-minus" />
								Effacer
							</VBtn>
							<VBtn type="submit" class="me-3">
								Soumettre
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
