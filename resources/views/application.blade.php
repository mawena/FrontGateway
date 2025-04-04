<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<link rel="icon" href="{{ asset('favicon.ico') }}" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>FrontGateway</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('loader.css') }}" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/monokai.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
	@vite(['resources/js/main.js'])
</head>

<body>
	<div id="app">
		<div id="loading-bg">
			<div class="loading-logo">
				<img src="/images/logo/logo.png" alt="Logo" style="width: 500px; height: 200px;" />

			</div>
			<div class=" loading">
				<div class="effect-1 effects"></div>
				<div class="effect-2 effects"></div>
				<div class="effect-3 effects"></div>
			</div>
		</div>
	</div>

	<script>
		const loaderColor = localStorage.getItem('vuexy-initial-loader-bg') || '#FFFFFF'
		const primaryColor = localStorage.getItem('vuexy-initial-loader-color') || '#245ABF'
		if (loaderColor)
			document.documentElement.style.setProperty('--initial-loader-bg', loaderColor)

		if (primaryColor)
			document.documentElement.style.setProperty('--initial-loader-color', primaryColor)
		// document.addEventListener("DOMContentLoaded", () => {
		// 	document.querySelectorAll('pre code').forEach((block) => {
		// 		hljs.highlightElement(block);
		// 	});
		// });
	</script>
</body>

</html>
