<!-- eslint-disable camelcase -->
<script setup>
definePage({
	meta: {
		action: 'create',
		subject: 'user',
	},
})
import { ref } from 'vue'

const router = useRouter()

const itemData = ref({
	name: "",
	email: "",
	password: "",
	profile: "",
	activated: null,
})

const getResetTransferError = () => {
	return {
		name: "",
		email: "",
		password: "",
		profile: "",
		activated: "",
	}
}
const itemError = ref(getResetTransferError())


const refForm = ref()

const onSubmit = () => {
	refForm.value?.validate().then(async ({ valid }) => {
		if (valid) {
			const res = await $api('/user', {
				method: 'POST',
				body: {
					name: itemData.value.name,
					email: itemData.value.email,
					password: itemData.value.password,
					profile: itemData.value.profile,
					activated: itemData.value.activated,
				},
			})

			itemError.value = getResetTransferError()
			if (res.status == 201) {
				snackbarMessage.value = "Utilisateur crée"
				snackbarCollor.value = "success"
				isSnackbarScrollReverseVisible.value = true
				router.push({name: 'admin-v2-user'})
			} else {
				if (res.errors.name) {
					itemError.value["name"] = res.errors.name[0]
					res.errors.name = null
				}
				if (res.errors.email) {
					itemError.value["email"] = res.errors.email[0]
					res.errors.email = null
				}
				if (res.errors.password) {
					itemError.value["password"] = res.errors.password[0]
					res.errors.password = null
				}
				if (res.errors.profile) {
					itemError.value["profile"] = res.errors.profile[0]
					res.errors.profile = null
				}
				if (res.errors.activated) {
					itemError.value["activated"] = res.errors.activated[0]
					res.errors.activated = null
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
const isPasswordVisible = ref(false)

const localUserData = useCookie('userData').value
</script>

<template>
	<div>
		<div class="d-flex flex-wrap justify-start justify-sm-space-between gap-y-4 gap-x-6 mb-6">
			<div class="d-flex flex-column justify-center">
				<h4 class="text-h4 font-weight-medium">
					Ajouter un backofficier
				</h4>
				<span>Informations sur le backofficier</span>
			</div>
		</div>
		<VForm ref="refForm" @submit.prevent="onSubmit">
			<VRow>
				<VCol md="12">
					<!-- 👉 PV Information -->
					<VCard class="mb-6" title="Informations de le backofficier">
						<VCardText>
							<VRow>
								<VCol cols="12" md="12" lg="6">
									<VTextField v-model="itemData.name" :error-messages="itemError.name" label="Nom" />
								</VCol>
								<VCol cols="12" md="12" lg="6">
									<VTextField v-model="itemData.email" :error-messages="itemError.email" type="email"
										label="Email" />
								</VCol>
								<VCol cols="12" md="12" lg="6">
									<VSelect v-model="itemData.activated"
										:items="[{ 'name': 'Activé', 'id': true }, { 'name': 'Désactivé', 'id': false }]"
										:error-messages="itemError.activated" label="Activation" item-title="name"
										item-value="id" required />
								</VCol>
								<VCol cols="12" md="12" lg="6">
									<VSelect v-model="itemData.profile"
										:items="localUserData.profileCanCreate"
										:error-messages="itemError.profile" label="Profile" item-title="name"
										item-value="key" required />
								</VCol>
								<VCol cols="12" md="12" lg="12">
									<VTextField v-model="itemData.password" label="Password" placeholder="············"
										:rules="[requiredValidator]" :type="isPasswordVisible ? 'text' : 'password'"
										:error-messages="itemError.password"
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
								Utilisateurs
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
