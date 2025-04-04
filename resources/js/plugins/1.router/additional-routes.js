// 👉 Redirects
export const redirects = [
	// ℹ️ We are redirecting to different pages based on role.
	// NOTE: Role is just for UI purposes. ACL is based on abilities.
	{
		path: '/',
		name: '',
		redirect: to => {
			// TODO: Get type from backend
			const userData = useCookie('userData')
			const userRole = userData.value?.role
			if (userRole === 'admin')
				return { name: 'user' }
			if (userRole === 'promoter')
				return { name: 'event' }
			if (userRole === 'supervisor')
				return { name: 'event' }
			if (userRole === 'event_planner')
				return { name: 'event' }

			return { name: 'login', query: to.query }
		},
	},
]
