<!-- eslint-disable camelcase -->
<script setup>
definePage({
	meta: {
		action: 'update',
		subject: 'user',
	},
})
import { useAxios } from '@vueuse/integrations/useAxios'
const router = useRouter()
const route = useRoute("user-edit-id")
let nextRoute = "/user";
import { onMounted } from 'vue'

const {
	data: userData,
	isLoading,
	error,
	execute: fetchUser
} = await useAxios(`http://localhost:8888/SERVICE-CLIENTS/clients/${route.params.id}`, {
	immediate: true, // on ne fait pas la requête tout de suite
})

const user = ref(userData.value)

// const {
// 	data: userData,
// 	execute: fetchUser
// } = useAxios(`http://localhost:8888/SERVICE-CLIENTS/clients/${route.params.id}`, {
// 	immediate: false, // on ne fait pas la requête tout de suite
// })

console.log("userData", userData.value)

const refForm = ref()
const onSubmit = () => {
	refForm.value?.validate().then(async ({ valid }) => {
		if (valid) {
			// const res = await $api(`/user/${route.params.id}`, {
			// 	method: 'PUT',
			// 	body: {
			// 		name: user.value.name,
			// 		email: user.value.email,
			// 		password: user.value.password,
			// 		activated: user.value.activated,
			// 	},
			// })

			const response = await useAxios(`/SERVICE/SERVICE-CLIENTS/clients/${route.params.id}`, {
				method: 'PUT',
				// immediate: false,
				data: {
					nom: user.value.nom,
					prenom: user.value.prenom,
					email: user.value.email,
				},
			})

			// userError.value = getEmptyError()
			// if (res.status == 200) {
			// 	router.push(nextRoute)
			// } else {
			// 	if (res.errors.name) {
			// 		userError.value["name"] = res.errors.name
			// 		res.errors.name = null
			// 	}
			// 	if (res.errors.email) {
			// 		userError.value["email"] = res.errors.email
			// 		res.errors.email = null
			// 	}
			// 	if (res.errors.password) {
			// 		userError.value["password"] = res.errors.password
			// 		res.errors.password = null
			// 	}
			// 	snackbarMessage.value = ""
			// 	let show = false
			// 	for (const key in res.errors) {
			// 		if (res.errors[key] != null) {
			// 			show = true;
			// 			snackbarCollor.value = "error"
			// 			snackbarMessage.value += res.errors[key] + "<br>";
			// 		}
			// 	}

			// }
			snackbarMessage.value = "Insertion effectuée avec succès";
			isSnackbarScrollReverseVisible.value = true;
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
const localUserData = useCookie('userData').value

onMounted(() => {
	fetchUser()
})
watch(userData, (newVal) => {
	console.log('userData updated:', newVal)
})
</script>

<template>
	<VRow>
		<VCol cols="12" md="12">
			<VForm ref="refForm" @submit.prevent="onSubmit">
				<VRow>
					<VCol cols="11">
					</VCol>
					<VCol cols="1" class="text-right">
						<VBtn append-icon="tabler-eye" :to="{ name: 'user-id', params: { id: route.params.id } }">
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
									<VCol cols="12" md="12" lg="12">
										<VTextField v-model="user.nom" label="Nom" />
									</VCol>
									<VCol cols="12" md="12" lg="12">
										<VTextField v-model="user.prenom" label="Prenom" />
									</VCol>
									<VCol cols="12" md="12" lg="12">
										<VTextField v-model="user.email" type="email" label="Email" />
									</VCol>
								</VRow>
							</VCardText>
						</VCard>

					</VCol>
					<VCol cols="12">
						<div class="d-flex flex-wrap justify-start justify-sm-space-between gap-y-4 gap-x-6 mb-6">
							<div class="d-flex flex-column justify-center">
								<VBtn :to="{ name: 'client' }">
									Clients
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
