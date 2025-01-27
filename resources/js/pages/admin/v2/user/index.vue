<!-- eslint-disable camelcase -->

<script setup>
definePage({
	meta: {
		action: 'read',
		subject: 'user',
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
const profileFilter = ref(null)
const activatedFilter = ref(null)
const headers = [
	{
		title: 'Nom',
		key: 'name'
	},
	{
		title: 'Email',
		key: 'email'
	},
	{
		title: 'Activation',
		key: 'activated'
	},
	{
		title: 'Actions',
		key: 'actions',
		sortable: false,
	},
]
const {
	data: userListData,
	execute: fetchUserList,
} = await useApi(createUrl('/user', {
	query: {
		search: searchQuery,
		page: page,
		profile: profileFilter,
		activated: activatedFilter
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
	const response = await $api(`user/${id}`, {
		method: 'DELETE'
	})
	if (response.status == 200) {
		isSnackbarScrollReverseVisible.value = true
		snackbarCollor.value = "success"
		actionComment.value = ""
		snackbarMessage.value = ""
		snackbarMessage.value = "Utilisateur Supprimé"
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
	await fetchUserList();
	isSnackbarScrollReverseVisible.value = true
}


const totalTransfer = computed(() => userListData.value.total)
const lastPage = computed(() => userListData.value.last_page)
// Math.min(Math.ceil(totalTransfer / itemsPerPage), 5)
const isSnackbarScrollReverseVisible = ref(false)
const snackbarMessage = ref("")
const snackbarCollor = ref("success")
const userList = computed(() => userListData.value.data)

const localUserData = useCookie('userData').value
</script>

<template>
	<div>
		<!-- 👉 widgets -->
		<VCard class="mb-6">
			<VCardText>
				<VRow>
					<VCardText>
						<h2>
							Liste des Backofficiers
						</h2>
					</VCardText>
				</VRow>
			</VCardText>
		</VCard>

		<!-- 👉 users -->
		<VCard title="Filtres" class="mb-6">
			<VCardText>
				<VRow>
					<VCol cols="12" sm="6">
						<AppSelect v-model="profileFilter" placeholder="Profil" item-title="name" item-value="key"
							:items="localUserData.profileCanCreate" clearable clear-icon="tabler-x" />
					</VCol>
					<VCol cols="12" sm="6">
						<AppSelect v-model="activatedFilter" placeholder="Activation" item-title="name" item-value="id"
							:items="[{ 'name': 'Activé', 'id': 'true' }, { 'name': 'Désactivé', 'id': 'false' }]"
							clearable clear-icon="tabler-x" />
					</VCol>
				</VRow>

				<VDivider class="my-4" />

			</VCardText>
			<div class="d-flex flex-wrap gap-4 mx-5">
				<!-- Barre de recherche -->
				<div class="flex-grow-1">
					<AppTextField v-model="searchQuery" placeholder="Rechercher un utiliateur" density="compact"
						class="w-100" />
				</div>

				<!-- Boutons "Nouveau" et "Recharger" -->
				<div class="d-flex gap-4">
					<VBtn v-if="$can('create', 'user')" color="primary" prepend-icon="tabler-plus"
						:to="{ name: 'admin-v2-user-add' }">
						Nouveau
					</VBtn>
					<VBtn :loading="loadings[3]" :disabled="loadings[3]" prepend-icon="tabler-refresh"
						@click="fetchUserList(); load(3)">
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
				:items="userList" :items-length="totalTransfer" class="text-no-wrap" @update:options="updateOptions">

				<template #item.activated="{ item }">
					<VAvatar variant="tonal" :color="{ true: 'success', false: 'error' }[item.activated]" class="me-4"
						size="40">
						<VIcon :icon="{ false: 'tabler-lock-check', true: 'tabler-lock-open' }[item.activated]"
							size="28" />
					</VAvatar>
					<div class="text-link text-base font-weight-medium d-inline-block">
						{{ { false: 'Désactivé', true: 'Activé' }[item.activated] }}
					</div>
				</template>

				<template #item.actions="{ item }">
					<div class="text-center">
						<div>
							<IconBtn v-if="$can('read', 'user') || $can('historical', 'user')"
								:to="{ name: 'admin-v2-user-id', params: { id: item.id } }">
								<VTooltip activator="parent" transition="scroll-x-transition" location="start">Details
								</VTooltip>
								<VIcon icon=" tabler-eye" />
							</IconBtn>
							<IconBtn v-if="$can('update', 'user')"
								:to="{ name: 'admin-v2-user-edit-id', params: { id: item.id } }">
								<VTooltip activator="parent" transition="scroll-x-transition" location="top">Modifier
								</VTooltip>
								<VIcon icon=" tabler-edit" />
							</IconBtn>
							<IconBtn v-if="$can('delete', 'user')" @click="selectedItemId = item.id; actionTitle = 'Supprimer le utilisateur',
								actionText = 'Voulez vous vraiment supprimer cet utilisateur?', actionFunction = apiDelete;
							actionButtonText = 'Supprimer'; commentPresence = false; isActionDialogVisible = true;">
								<VTooltip activator="parent" transition="scroll-x-transition" location="end">Supprimer
								</VTooltip>
								<VIcon icon="tabler-trash" color='error' />
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
