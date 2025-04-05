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
let nextRoute = "/product";
import { onMounted } from 'vue'

const {
	data: itemData,
	isLoading,
	error,
	execute: fetchUser
} = await useAxios(`/api/GATEWAY/SERVICE-CLIENTS/clients/${route.params.id}`, {
	immediate: true, // on ne fait pas la requête tout de suite
})

const item = ref(itemData.value)


console.log("itemData", itemData.value)

const refForm = ref()
const onSubmit = () => {
	refForm.value?.validate().then(async ({ valid }) => {
		if (valid) {
			const { response, data, error } = await useAxios(`/api/GATEWAY/SERVICE-CLIENTS/clients/${route.params.id}`, {
				method: 'PUT',
				data: {
					nom: item.value.nom,
					prenom: item.value.prenom,
					email: item.value.email,
				},
			})

			if (response.value) {
				if (response.value.status == 200) {
					console.log('Statut HTTP:', response.value.status) // ex: 200
					router.push(nextRoute)
				}
				console.log('Statut HTTP:', response.value.status) // ex: 200
			} else if (error.value) {
				console.error('Erreur:', error.value)
			}
			snackbarMessage.value = "Modification effectuée avec succès";
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
watch(itemData, (newVal) => {
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
						<VCard class="mb-6" title="Modification du client">
							<VCardText>
								<VRow>
									<VCol cols="12" md="12" lg="12">
										<VTextField v-model="item.nom" label="Nom" />
									</VCol>
									<VCol cols="12" md="12" lg="12">
										<VTextField v-model="item.prenom" label="Prenom" />
									</VCol>
									<VCol cols="12" md="12" lg="12">
										<VTextField type="email" v-model="item.email" label="Email" />
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
