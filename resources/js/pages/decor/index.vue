<!-- eslint-disable camelcase -->

<script setup>
definePage({
	meta: {
		action: 'read',
		subject: 'decor',
	},
})
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { paginationMeta } from '@api-utils/paginationMeta'
import { $api } from '@/utils/api';


const searchQuery = ref('')
const loadings = ref([])
const itemsPerPage = ref(8)
const page = ref(1)
const selectedItemId = ref(0)
const isActionDialogVisible = ref(false)
const actionTitle = ref("")
const actionText = ref("")
const actionButtonText = ref("")
const actionFunction = ref()
const actionComment = ref("cancel")
const commentPresence = ref(false)
const actionStatus = ref("waiting");
const isSnackbarScrollReverseVisible = ref(false)
const snackbarMessage = ref("")
const snackbarCollor = ref("success")
const validationFilter = ref(null)
const localUserData = useCookie('userData').value
const userIdFilter = localUserData.role == "promoter" ? localUserData.id : null
const headers = [
	{
		title: 'Nom',
		key: 'short_name'
	},
	...(localUserData.role !== "promoter"
		? [{ title: 'Promoteur', key: 'user.name' }]
		: []),
	{
		title: 'Etat',
		key: 'validation_fr'
	},
	{
		title: 'Actions',
		key: 'actions',
		align: "center",
		sortable: false,
	},
]
const {
	data: decorListData,
	execute: fetchEventList,
} = await useApi(createUrl('/decor', {
	query: {
		search: searchQuery,
		validation: validationFilter,
		user_id: userIdFilter,
		with_user: "true",
		with_event: "true",
		page: page,
	},
}))

const load = i => {
	loadings.value[i] = true
	setTimeout(() => {
		loadings.value[i] = false
	}, 1000)
}

const updateOptions = options => {
	page.value = options.page
}


const apiDelete = async id => {
	const response = await $api(`decor/${id}`, {
		method: 'DELETE'
	})
	if (response.status == 200) {
		isSnackbarScrollReverseVisible.value = true
		snackbarCollor.value = "success"
		actionComment.value = ""
		snackbarMessage.value = ""
		snackbarMessage.value = "Decor Supprimé"
	} else {
		snackbarCollor.value = "error"
		isSnackbarScrollReverseVisible.value = true
		snackbarMessage.value = ""
		for (const key in response.errors) {
			response.errors[key].forEach(message => {
				snackbarMessage.value += "" + message + "<br>";
			})
		}
	}
	await fetchEventList();
	isSnackbarScrollReverseVisible.value = true
}

const apiChangeStatus = async id => {
	const response = await $api(`decor/change-validation/${id}`, {
		method: "PUT",
		body: { validation: actionStatus.value },
	});
	if (response.status == 200) {
		isSnackbarScrollReverseVisible.value = true
		snackbarCollor.value = "success"
		actionComment.value = ""
		snackbarMessage.value = ""
		snackbarMessage.value = "Decor " + actionStatus.value == "validated" ? "Validé" : "Rejeté"
	} else {
		snackbarCollor.value = "error"
		isSnackbarScrollReverseVisible.value = true
		snackbarMessage.value = ""
		for (const key in response.errors) {
			response.errors[key].forEach(message => {
				snackbarMessage.value += "" + message + "<br>";
			})
		}
	}
	await fetchEventList();
	isSnackbarScrollReverseVisible.value = true
}


const totalTransfer = computed(() => decorListData.value.total)
const lastPage = computed(() => decorListData.value.last_page)
// Math.min(Math.ceil(totalTransfer / itemsPerPage), 5)
const decorList = computed(() => decorListData.value.data)


</script>

<template>
	<div>
		<!-- 👉 widgets -->
		<VCard class="mb-6">
			<VCardText>
				<VRow>
					<VCardText>
						<h2>
							Liste des Décors
						</h2>
					</VCardText>
				</VRow>
			</VCardText>
		</VCard>

		<!-- 👉 decors -->
		<VCard title="Filtres" class="mb-6">
			<VCardText>
				<VRow>
					<VCol cols="12" sm="12">
						<AppSelect v-model="validationFilter" placeholder="Validation" item-title="name"
							item-value="key"
							:items="[{ 'key': 'pending', 'name': 'En attente' }, { 'key': 'validated', 'name': 'Validés' }, { 'key': 'rejected', 'name': 'Rejetés' }]"
							clearable clear-icon="tabler-x" />
					</VCol>
				</VRow>

				<VDivider class="my-4" />

			</VCardText>
			<div class="d-flex flex-wrap gap-4 mx-5">
				<!-- Barre de recherche -->
				<div class="flex-grow-1">
					<AppTextField v-model="searchQuery" placeholder="Rechercher un decor" density="compact"
						class="w-100" />
				</div>

				<!-- Boutons "Nouveau" et "Recharger" -->
				<div class="d-flex gap-4">
					<VBtn v-if="$can('create', 'decor')" color="primary" prepend-icon="tabler-plus"
						:to="{ name: 'decor-add' }">
						Nouveau
					</VBtn>
					<VBtn :loading="loadings[3]" :disabled="loadings[3]" prepend-icon="tabler-refresh"
						@click="fetchEventList(); load(3)">
						Recharger
						<template #loader>
							<span class="custom-loader">
								<VIcon icon="tabler-refresh" />
							</span>
						</template>
					</VBtn>
				</div>
			</div>

			<VDivider class="mt-4" />


			<!-- 👉 Datatable  -->
			<VDataTableServer v-model:items-per-page="itemsPerPage" v-model:page="page" :headers="headers"
				:items="decorList" :items-length="totalTransfer" class="text-no-wrap" @update:options="updateOptions">

				<template #item.validation_fr="{ item }">
					<VAvatar variant="tonal"
						:color="{ 'pending': 'warning', 'validated': 'success', 'rejected': 'error' }[item.validation]"
						class="me-4" size="40">
						<VIcon
							:icon="{ 'pending': 'tabler-clock', 'validated': 'tabler-check', 'rejected': 'tabler-x' }[item.validation]"
							size="28" />
					</VAvatar>
					<div class="text-link text-base font-weight-medium d-inline-block">
						{{ item.validation_fr }}
					</div>
				</template>

				<template #item.actions="{ item }">
					<div class="text-center">
						<div>
							<IconBtn v-if="$can('read', 'decor') || $can('historical', 'decor')"
								:to="{ name: 'decor-id', params: { id: item.id } }">
								<VTooltip activator="parent" transition="scroll-x-transition" location="start">Details
								</VTooltip>
								<VIcon icon=" tabler-eye" />
							</IconBtn>
							<IconBtn v-if="$can('update', 'decor')"
								:to="{ name: 'decor-edit-id', params: { id: item.id } }">
								<VTooltip activator="parent" transition="scroll-x-transition" location="top">Modifier
								</VTooltip>
								<VIcon icon=" tabler-edit" />
							</IconBtn>
							<IconBtn v-if="$can('delete', 'decor')" @click="selectedItemId = item.id; actionTitle = 'Supprimer le Decor',
								actionText = 'Voulez vous vraiment supprimer cet Decor?', actionFunction = apiDelete;
							actionButtonText = 'Supprimer'; commentPresence = false; isActionDialogVisible = true;">
								<VTooltip activator="parent" transition="scroll-x-transition" location="end">Supprimer
								</VTooltip>
								<VIcon icon="tabler-trash" color='error' />
							</IconBtn>
						</div>
						<div v-if="localUserData.role == 'admin'">
							<VDivider />
							<IconBtn
								v-if="$can('reject', 'decor') && localUserData.role == 'admin' && item.validation != 'rejected'"
								@click="selectedItemId = item.id; (actionTitle = 'Rejeter le decor'), (actionText = 'Voulez vous vraiment rejeter cet decor?'), (actionFunction = apiChangeStatus); actionButtonText = 'Rejeter'; commentPresence = false; actionStatus = 'rejected'; isActionDialogVisible = true;">
								<VTooltip activator="parent" transition="scroll-x-transition" location="start">Rejeter
								</VTooltip>
								<VIcon icon="tabler-x" color="error" />
							</IconBtn>
							<IconBtn
								v-if="$can('validate', 'decor') && localUserData.role == 'admin' && item.validation != 'validated'"
								@click="selectedItemId = item.id; (actionTitle = 'Valider le decor'), (actionText = 'Voulez vous vraiment valider cet decor?'), (actionFunction = apiChangeStatus); actionButtonText = 'Valider'; commentPresence = false; actionStatus = 'validated'; isActionDialogVisible = true;">
								<VTooltip activator="parent" transition="scroll-x-transition" location="end">Valider
								</VTooltip>
								<VIcon icon="tabler-check" color="success" />
							</IconBtn>
						</div>
					</div>
				</template>

				<template #bottom>
					<VDivider />

					<div class="d-flex align-center justify-space-between flex-wrap gap-3 pa-5 pt-3">
						<p class="text-sm text-medium-emphasis mb-0">
							{{ paginationMeta({ page, itemsPerPage }, totalTransfer) }}
						</p>

						<VPagination v-model="page" :length="lastPage"
							:total-visible="$vuetify.display.xs ? 1 : Math.min(lastPage, 5)">
							<template #prev="slotProps">
								<VBtn variant="tonal" color="default" v-bind="slotProps" :icon="false">
									<VIcon start icon="tabler-arrow-left" />
									Précedent
								</VBtn>
							</template>

							<template #next="slotProps">
								<VBtn variant="tonal" color="default" v-bind="slotProps" :icon="false">
									Suivant
									<VIcon end icon="tabler-arrow-right" />
								</VBtn>
							</template>
						</VPagination>
					</div>
				</template>
			</VDataTableServer>
		</VCard>


		<VDialog v-model="isActionDialogVisible" class="v-dialog-sm">
			<!-- Dialog close btn -->
			<DialogCloseBtn @click="isActionDialogVisible = !isActionDialogVisible" />

			<!-- Dialog De suppression -->
			<VCard :title="actionTitle">
				<VCardText>
					{{ actionText }}

					<VTextarea v-if="commentPresence" class="mt-3" v-model="actionComment" label="Commentaire"
						placeholder="Ex: RAS" />
				</VCardText>

				<VCardText class="d-flex justify-end gap-3 flex-wrap">
					<VBtn color="secondary" variant="tonal" @click="isActionDialogVisible = false">
						Retour
					</VBtn>
					<VBtn @click="actionFunction(selectedItemId); isActionDialogVisible = false">
						{{ actionButtonText }}
					</VBtn>
				</VCardText>
			</VCard>
		</VDialog>
		<VSnackbar v-model="isSnackbarScrollReverseVisible" transition="scale-transition" location="top end"
			:color="snackbarCollor">
			<div v-html="snackbarMessage"></div>
		</VSnackbar>
	</div>
</template>

<style lang="scss" scoped>
.custom-loader {
	display: flex;
	animation: loader 1s infinite;
}

@keyframes loader {
	from {
		transform: rotate(0);
	}

	to {
		transform: rotate(360deg);
	}
}

.full-width-icon {
	display: flex;
	justify-content: center;
	align-items: center;
	width: 100%;
	height: 100%;
}
</style>
