export const db = {
	searchItems: [
		{
			title: 'Cartes',
			category: 'cartes',
			children: [
				{
					url: { name: 'credit-card-add' },
					icon: 'tabler-plus',
					title: 'Ajouter des cartes',
				},
				{
					url: { name: 'credit-card' },
					icon: 'tabler-credit-card',
					title: 'Voir les cartes',
				}
			],
		},{
			title: 'Transferts',
			category: 'transferts',
			children: [
				{
					url: { name: 'transfer-add' },
					icon: 'tabler-plus',
					title: 'Faire un nouveau transfert',
				},
				{
					url: { name: 'transfer' },
					icon: 'tabler-transfer',
					title: 'Voir les transferts',
				}
			],
		},{
			title: 'Ventes',
			category: 'ventes',
			children: [
				{
					url: { name: 'sale-add' },
					icon: 'tabler-mood-dollar',
					title: 'Faire de nouvelles ventes',
				},
				{
					url: { name: 'sale' },
					icon: 'tabler-coin',
					title: 'Voir les ventes',
				}
			],
		},
	],
}
