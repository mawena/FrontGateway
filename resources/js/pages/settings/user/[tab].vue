<script setup>
import AccountSettingsAccount from '@/views/settings/user/tabs/AccountSettingsAccount.vue'
import AccountSettingsSecurity from '@/views/settings/user/tabs/AccountSettingsSecurity.vue'
definePage({
	meta: {
		action: 'read',
		subject: 'settings-user',
	},
})
const route = useRoute('settings-user-tab')

const activeTab = computed({
	get: () => route.params.tab,
	set: () => route.params.tab,
})

// tabs
const tabs = [
	{
		title: 'Compte',
		icon: 'tabler-users',
		tab: 'account',
	},
	{
		title: 'Sécurité',
		icon: 'tabler-lock',
		tab: 'security',
	},
]

</script>

<template>
	<div>
		<VTabs v-model="activeTab" class="v-tabs-pill">
			<VTab v-for="item in tabs" :key="item.icon" :value="item.tab"
				:to="{ name: 'settings-user-tab', params: { tab: item.tab } }">
				<VIcon size="20" start :icon="item.icon" />
				{{ item.title }}
			</VTab>
		</VTabs>

		<VWindow v-model="activeTab" class="mt-6 disable-tab-transition" :touch="false">
			<VWindowItem value="account">
				<AccountSettingsAccount />
			</VWindowItem>

			<VWindowItem value="security">
				<AccountSettingsSecurity />
			</VWindowItem>
		</VWindow>
	</div>
</template>
