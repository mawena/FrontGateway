<!-- eslint-disable camelcase -->
<script setup>
definePage({
	meta: {
		action: 'read',
		subject: 'event',
	},
})
const router = useRouter()
const route = useRoute('event-id')
const loadings = ref([])


const {
	data: eventData,
	execute: fetchEvent,
} = await useApi(createUrl(`/event/${route.params.id}`, {
	query: {

	},
}))

if (eventData.value.status != 200) {
	router.push("/event")
}

const load = i => {
	loadings.value[i] = true
	setTimeout(() => {
		loadings.value[i] = false
	}, 1000)
}

const tableData = computed(() => [
	{ "title": "Nom", "value": eventData.value.data.Event.name },
	{ "title": "Date de debut", "value": eventData.value.data.Event.start_date_fr },
	{ "title": "Date de fin", "value": eventData.value.data.Event.end_date_fr },
	{ "title": "Lieu", "value": eventData.value.data.Event.place },
	{ "title": "Type", "value": eventData.value.data.Event.type },
	{ "title": "Nombre de personnes attendus", "value": eventData.value.data.Event.nb_expected },
	{ "title": "Entrée", "value": eventData.value.data.Event.entrance_fr },
	{ "title": "Prix d'entrée", "value": eventData.value.data.Event.entrance == "paid" ? eventData.value.data.Event.entry_price_formated : '-' },
])
const backRoute = "admin-v2-event"

import CreateDealBackgroundDark from '@images/pages/DealTypeBackground-dark.png'
import CreateDealBackgroundLight from '@images/pages/DealTypeBackground-light.png'
const createDealBackground = useGenerateImageVariant(CreateDealBackgroundLight, CreateDealBackgroundDark)

</script>

<template>
	<section v-if="eventData">
		<VRow>
			<VCol cols="12">
				<VCard>
					<VCardText class="d-flex flex-wrap justify-space-between flex-column flex-sm-row print-row text-lg">
						<VCol cols="10">
							<VBtn :to="{ name: backRoute }">
								<VIcon start icon="tabler-calendar-event" />
								Evenements
							</VBtn>
						</VCol>
						<VCol cols="2" class="text-right">
							<VBtn :to="{ name: 'admin-v2-event-edit-id', params: { id: route.params.id } }"
								color="primary">
								Modifier
								<VIcon end icon="tabler-edit" />
							</VBtn>
						</VCol>

						<VCol v-if="eventData.data.Event.poster_path" cols="12">
							<h2>Poster : </h2>
							<br>
							<div
								class="d-flex align-center justify-center w-100 deal-type-image-wrapper border rounded px-5 pt-2 pb-5">

								<VImg :src="'/storage/' + eventData.data.Event.poster_path" />
								<VImg :src="createDealBackground"
									class="position-absolute deal-type-background-img d-md-block d-none" />
							</div>
						</VCol>

						<VCol cols="12">
							<h2>Details:</h2>
						</VCol>
						<VCol cols="12">
							<VTable class="text-no-wrap">
								<tbody>
									<tr v-for="item in tableData" :key="item.key">
										<td colspan="5">
											{{ item.title }}
										</td>
										<td colspan="1">
											{{ item.value }}
										</td>
									</tr>
								</tbody>
							</VTable>
						</VCol>

						<VCol v-if="eventData.data.Event.description_summary" cols="12">
							<h2>Description Résumé : </h2>
							<br>
							<pre class="scroll-container">{{ eventData.data.Event.description_summary ?? '-' }}</pre>
						</VCol>

						<VCol v-if="eventData.data.Event.description" cols="12">
							<h2>Description Complète : </h2>
							<br>
							<p>{{ eventData.data.Event.description ?? '-' }}</p>
						</VCol>
					</VCardText>
				</VCard>
			</VCol>
		</VRow>
	</section>
</template>

<style lang="scss">
.invoice-preview-table {
	--v-table-row-height: 44px !important;
}

@media print {
	.v-theme--dark {
		--v-theme-surface: 255, 255, 255;
		--v-theme-on-surface: 94, 86, 105;
	}

	body {
		background: none !important;
	}

	@page {
		margin: 0;
		size: auto;
	}

	.layout-page-content,
	.v-row,
	.v-col-md-9 {
		padding: 0;
		margin: 0;
	}

	.product-buy-now {
		display: none;
	}

	.v-navigation-drawer,
	.layout-vertical-nav,
	.app-customizer-toggler,
	.layout-footer,
	.layout-navbar,
	.layout-navbar-and-nav-container {
		display: none;
	}

	.v-card {
		box-shadow: none !important;

		.print-row {
			flex-direction: row !important;
		}
	}

	.layout-content-wrapper {
		padding-inline-start: 0 !important;
	}

	.v-table__wrapper {
		overflow: hidden !important;
	}
}

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

.scroll-container {
	max-width: 100%;
	/* Pour limiter la largeur à celle du conteneur parent */
	overflow-x: auto;
	/* Ajoute une barre de défilement horizontale */
	white-space: pre;
	/* Préserve les espaces et les nouvelles lignes */
}

pre {
	margin: 0;
	/* Supprime la marge par défaut */
}
</style>
