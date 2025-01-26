<script setup>
import { useCookie } from '@/@core/composable/useCookie';

const accountData = useCookie('userData').value

</script>

<template>
	<VRow>
		<VCol cols="12">
			<VCard title="Details du compte utilisateur">
				<VCardText class="pt-2">
					<!-- 👉 Form -->
					<VForm class="mt-6">
						<VRow>
							<!-- 👉 First Name -->
							<VCol md="6" cols="12">
								<AppTextField v-model="accountData.username" label="Nom" readonly />
							</VCol>

							<!-- 👉 Last Name -->
							<VCol md="6" cols="12">
								<AppTextField v-model="accountData.role_fr" label="Profil" readonly />
							</VCol>

							<!-- 👉 Email -->
							<VCol cols="12" md="12">
								<AppTextField v-model="accountData.email" label="E-mail" type="email" readonly />
							</VCol>

							<!-- 👉 Flexcube -->
							<VCol cols="12" md="12">
								<AppTextField v-model="accountData.flexcube_user_id" label="User_id FLEXCUBE"
									readonly />
							</VCol>
						</VRow>
					</VForm>
				</VCardText>
			</VCard>
		</VCol>
	</VRow>

	<!-- Confirm Dialog -->
	<ConfirmDialog v-model:isDialogVisible="isConfirmDialogOpen"
		confirmation-question="Are you sure you want to deactivate your account?" confirm-title="Deactivated!"
		confirm-msg="Your account has been deactivated successfully." cancel-title="Cancelled"
		cancel-msg="Account Deactivation Cancelled!" />
</template>
