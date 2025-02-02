<!-- eslint-disable camelcase -->
<script setup>
definePage({
	meta: {
		action: 'update',
		subject: 'decor',
	},
})
const router = useRouter()
const route = useRoute("decor-edit-id")
let nextRoute = "/admin/v2/decor";

const getEmptyError = () => {
	return {
		event_id: "",
		name: "",
		start_use: "",
		end_use: "",
		file: "",
	}
}

const itemError = ref(getEmptyError())

const {
	data: itemData,
} = await useApi(createUrl(`/decor/${route.params.id}`, {
	query: {
	},
}))
const item = ref(itemData.value.data.Decor)
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
				item.value.file = fileReader.result
			}
		}
	}
}

const onSubmit = () => {
	refForm.value?.validate().then(async ({ valid }) => {
		if (valid) {
			const res = await $api(`/decor/${route.params.id}`, {
				method: 'PUT',
				body: {
					event_id: item.value.event_id,
					name: item.value.name,
					start_use: item.value.start_use,
					end_use: item.value.end_use,
					file: item.value.file,
				},
			})

			itemError.value = getEmptyError()
			if (res.status == 200) {
				router.push({ name: 'admin-v2-decor-id', params: { id: route.params.id } })
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
				// refForm.value?.resetValidation()
			})
		}
	})
}

const isSnackbarScrollReverseVisible = ref(false)
const snackbarMessage = ref("")
const snackbarCollor = ref("success")
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
										<VFileInput accept=".png,.jpg,.jpeg,.webp" label="Decor"
											:error-messages="itemError.file" @input="changeFile" required />
									</VCol>
									<VCol cols="12" md="12" lg="5">
										<VAutocomplete v-model="item.event_id" :error-messages="itemError.event_id"
											label="Evenement" :items="eventList" item-title="name" item-value="id"
											clearable />
									</VCol>
									<VCol cols="12" md="12" lg="5">
										<VTextField v-model="item.name" :error-messages="itemError.name" label="Nom"
											required />
									</VCol>
									<VCol cols="12" md="12" lg="6">
										<AppDateTimePicker v-model="item.start_use"
											:error-messages="itemError.start_use" label="Date de début" required />
									</VCol>
									<VCol cols="12" md="12" lg="6">
										<AppDateTimePicker v-model="item.end_use" :error-messages="itemError.end_use"
											label="Date de fin" />
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
		</VCol>
	</VRow>

	<VSnackbar v-model="isSnackbarScrollReverseVisible" transition="scale-transition" location="top end"
		:color="snackbarCollor">
		{{ snackbarMessage }}
	</VSnackbar>
</template>
