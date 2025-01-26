<script setup>
import { useTheme } from 'vuetify'
import { useStorage } from '@vueuse/core'
import ScrollToTop from '@core/components/ScrollToTop.vue'
import initCore from '@core/initCore'
import {
	initConfigStore,
	useConfigStore,
} from '@core/stores/config'
import { hexToRgb } from '@layouts/utils'
import {
	cookieRef,
	namespaceConfig,
} from '@layouts/stores/config'

// const vuetifyTheme = useTheme()
// vuetifyTheme.themes.value[vuetifyTheme.name.value].colors.primary = "FF002E"
// vuetifyTheme.themes.value[vuetifyTheme.name.value].colors['primary-darken-1'] = "636466"
// cookieRef(`${vuetifyTheme.name.value}ThemePrimaryColor`, null).value = "FF002E"
// cookieRef(`${vuetifyTheme.name.value}ThemePrimaryDarkenColor`, null).value = "636466"
// useStorage(namespaceConfig('initial-loader-color'), null).value = "FF002E"

const { global } = useTheme()

// ℹ️ Sync current theme with initial loader theme
initCore()
initConfigStore()

const configStore = useConfigStore()
</script>

<template>
	<VLocaleProvider :rtl="configStore.isAppRTL">
		<!-- ℹ️ This is required to set the background color of active nav link based on currently active global theme's primary -->
		<VApp :style="`--v-global-theme-primary: ${hexToRgb(global.current.value.colors.primary)}`">
			<RouterView />
			<ScrollToTop />
		</VApp>
	</VLocaleProvider>
</template>
