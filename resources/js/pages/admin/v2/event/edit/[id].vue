<!-- eslint-disable camelcase -->
<script setup>
definePage({
	meta: {
		action: 'update',
		subject: 'event',
	},
})
const router = useRouter()
const route = useRoute("event-edit-id")
let nextRoute = "/admin/v2/event";

const getEmptyError = () => {
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

const itemError = ref(getEmptyError())

const {
	data: itemData,
} = await useApi(createUrl(`/event/${route.params.id}`, {
	query: {
	},
}))
const item = ref(itemData.value.data.Event)
const refForm = ref()

const changeFile = file => {
	const fileReader = new FileReader()
	const { files } = file.target
	if (files && files.length) {
		fileReader.readAsDataURL(files[0])
		fileReader.onload = () => {
			if (typeof fileReader.result === 'string') {
				item.value.poster = fileReader.result
			}
		}
	}
}

const onSubmit = () => {
	refForm.value?.validate().then(async ({ valid }) => {
		if (valid) {
			const res = await $api(`/event/${route.params.id}`, {
				method: 'PUT',
				body: {
					name: item.value.name,
					start_date: item.value.start_date,
					end_date: item.value.end_date,
					place: item.value.place,
					type: item.value.type,
					nb_expected: item.value.nb_expected,
					entrance: item.value.entrance,
					entry_price: item.value.entry_price,
					contact: item.value.contact,
					description_summary: item.value.description_summary,
					description: item.value.description,
					poster: item.value.poster,
				},
			})

			itemError.value = getEmptyError()
			if (res.status == 200) {
				router.push({ name: 'admin-v2-event-id', params: { id: route.params.id } })
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
				// refForm.value?.resetValidation()
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
	<VRow>
		<VCol cols="12" md="12">
			<VForm ref="refForm" @submit.prevent="onSubmit">
				<VRow>
					<VCol cols="11">
					</VCol>
					<VCol cols="1" class="text-right">
						<VBtn append-icon="tabler-eye"
							:to="{ name: 'admin-v2-event-id', params: { id: route.params.id } }">
							Voir
						</VBtn>
					</VCol>
				</VRow>
				<VRow>
					<VCol md="12">
						<!-- 👉 creditCard Information -->
						<VCard class="mb-6" title="Modification du l'utilisateur">
							<VCardText>
								<VRow>
									<VCol cols="12" md="12" lg="2">
										<VFileInput accept=".png,.jpg,.jpeg,.webp" label="Affiche"
											:error-messages="itemError.file" @input="changeFile" required />
									</VCol>
									<VCol cols="12" md="12" lg="10">
										<VTextField v-model="item.name" :error-messages="itemError.name" label="Nom" />
									</VCol>
									<VCol cols="12" md="12" lg="6">
										<AppDateTimePicker v-model="item.start_date"
											:error-messages="itemError.start_date" label="Date de debut" />
									</VCol>
									<VCol cols="12" md="12" lg="6">
										<AppDateTimePicker v-model="item.end_date" :error-messages="itemError.end_date"
											label="Date de fin" />
									</VCol>
									<VCol cols="12" md="12" lg="4">
										<VAutocomplete v-model="item.entrance" :error-messages="itemError.entrance"
											label="Entrée"
											:items="[{ 'key': 'paid', 'name': 'Payante' }, { 'key': 'free', 'name': 'Gratuite' }]"
											item-title="name" item-value="key" />
									</VCol>
									<VCol cols="12" md="12" lg="4">
										<VTextField v-model="item.type" :error-messages="itemError.type" label="Type" />
									</VCol>
									<VCol cols="12" md="12" lg="4">
										<VTextField v-model="item.nb_expected" :error-messages="itemError.nb_expected"
											label="Nombre de personnes attendus" type="number" />
									</VCol>
									<VCol cols="12" md="12" lg="12">
										<VTextField v-model="item.place" :error-messages="itemError.place"
											label="Lieu" />
									</VCol>
									<VCol cols="12" md="12" lg="12" v-if="item.entrance == 'paid'">
										<VTextField v-model="item.entry_price" :error-messages="itemError.entry_price"
											label="Prix d'entrée" type="number" />
									</VCol>
									<VCol cols="12" md="12" lg="8">
										<VTextField v-model="item.description_summary"
											:error-messages="itemError.description_summary"
											label="Description résumé" />
									</VCol>
									<VCol cols="12" md="12" lg="4">
										<VTextField v-model="item.contact" :error-messages="itemError.contact"
											label="Contact" />
									</VCol>
									<VCol cols="12" md="12" lg="12">
										<VTextarea v-model="item.description" :error-messages="itemError.description"
											label="Description Detaillé" />
									</VCol>
								</VRow>
							</VCardText>
						</VCard>

					</VCol>
					<VCol cols="12">
						<div class="d-flex flex-wrap justify-start justify-sm-space-between gap-y-4 gap-x-6 mb-6">
							<div class="d-flex flex-column justify-center">
								<VBtn :to="{ name: 'admin-v2-event' }">
									<VIcon start icon="tabler-calendar-event" />
									Liste des évenements
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
		</VCol>
	</VRow>

	<VSnackbar v-model="isSnackbarScrollReverseVisible" transition="scale-transition" location="top end"
		:color="snackbarCollor">
		{{ snackbarMessage }}
	</VSnackbar>
</template>
