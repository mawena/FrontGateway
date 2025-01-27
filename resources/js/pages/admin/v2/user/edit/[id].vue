<!-- eslint-disable camelcase -->
<script setup>
definePage({
	meta: {
		action: 'update',
		subject: 'user',
	},
})
const router = useRouter()
const route = useRoute("user-edit-id")
let nextRoute = "/admin/v2/user";

const getEmptyError = () => {
	return {
		name: "",
		email: "",
		password: "",
		profile: "",
		activated: "",
	}
}

const userError = ref(getEmptyError())

const {
	data: userData,
} = await useApi(createUrl(`/user/${route.params.id}`, {
	query: {
	},
}))
const user = ref(userData.value.data.User)
const refForm = ref()

const onSubmit = () => {
	refForm.value?.validate().then(async ({ valid }) => {
		if (valid) {
			const res = await $api(`/user/${route.params.id}`, {
				method: 'PUT',
				body: {
					name: user.value.name,
					email: user.value.email,
					password: user.value.password,
					profile: user.value.profile,
					activated: user.value.activated,
				},
			})

			userError.value = getEmptyError()
			if (res.status == 200) {
				router.push(nextRoute)
			} else {
				if (res.errors.name) {
					userError.value["name"] = res.errors.name[0]
					res.errors.name = null
				}
				if (res.errors.email) {
					userError.value["email"] = res.errors.email[0]
					res.errors.email = null
				}
				if (res.errors.password) {
					userError.value["password"] = res.errors.password[0]
					res.errors.password = null
				}
				if (res.errors.profile) {
					userError.value["profile"] = res.errors.profile[0]
					res.errors.profile = null
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
							:to="{ name: 'admin-v2-user-id', params: { id: route.params.id } }">
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
									<VCol cols="12" md="12" lg="6">
										<VTextField v-model="user.name" :error-messages="userError.name" label="Nom" />
									</VCol>
									<VCol cols="12" md="12" lg="6">
										<VTextField v-model="user.email" :error-messages="userError.email" type="email"
											label="Email" />
									</VCol>
									<VCol cols="12" md="12" lg="6">
										<VSelect v-model="user.activated"
											:items="[{ 'name': 'Activé', 'id': true }, { 'name': 'Désactivé', 'id': false }]"
											:error-messages="userError.activated" label="Activation" item-title="name"
											item-value="id" required />
									</VCol>
									<VCol cols="12" md="12" lg="6">
										<VSelect v-model="user.profile" :items="localUserData.profileCanCreate"
											:error-messages="userError.profile" label="Profile" item-title="name"
											item-value="key" required />
									</VCol>
									<VCol cols="12" md="12" lg="12">
										<VTextField v-model="user.password" label="Password" placeholder="············"
											:type="isPasswordVisible ? 'text' : 'password'"
											:error-messages="userError.password"
											:append-inner-icon="isPasswordVisible ? 'tabler-eye-off' : 'tabler-eye'"
											@click:append-inner="isPasswordVisible = !isPasswordVisible" class="mb-8" />
									</VCol>
								</VRow>
							</VCardText>
						</VCard>

					</VCol>
					<VCol cols="12">
						<div class="d-flex flex-wrap justify-start justify-sm-space-between gap-y-4 gap-x-6 mb-6">
							<div class="d-flex flex-column justify-center">
								<VBtn :to="{ name: 'admin-v2-user' }">
									Backofficiers
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
