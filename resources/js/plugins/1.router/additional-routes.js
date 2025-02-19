// 👉 Redirects
export const redirects = [
	// ℹ️ We are redirecting to different pages based on role.
	// NOTE: Role is just for UI purposes. ACL is based on abilities.
	{
		path: '/admin/v2',
		name: 'admin-v2',
		redirect: to => {
			// TODO: Get type from backend
			const userData = useCookie('userData')
			const userRole = userData.value?.role
			if (userRole === 'admin')
				return { name: 'admin-v2-user' }
			if (userRole === 'promoter')
				return { name: 'admin-v2-event' }
			if (userRole === 'supervisor')
				return { name: 'admin-v2-event' }
			if (userRole === 'event_planner')
				return { name: 'admin-v2-event' }

			return { name: 'admin-v2-login', query: to.query }
		},
	},
]
