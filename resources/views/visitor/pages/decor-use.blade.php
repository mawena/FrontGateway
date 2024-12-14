@extends('visitor.base')

@section('decor.use.head')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
	<style>
		body {
			font-family: Arial, sans-serif;
			text-align: center;
			margin-top: 20px;
		}

		img,
		canvas {
			max-width: 80%;
			margin-top: 20px;
		}

		button {
			margin-top: 10px;
			padding: 10px 20px;
			font-size: 16px;
			cursor: pointer;
		}

		.modal {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.7);
			display: flex;
			justify-content: center;
			align-items: center;
			z-index: 9999;
			display: none;
		}

		.modal-content {
			background: white;
			padding: 20px;
			border-radius: 10px;
			text-align: center;
			width: 90%;
			/* Diminuez cette valeur si nécessaire */
			max-width: 500px;
			/* Limitez la largeur maximale */
			max-height: 90%;
			/* Limitez la hauteur maximale */
			overflow-y: auto;
			/* Ajoute un défilement si le contenu dépasse */
			box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
		}

		.modal-content img {
			max-width: 100%;
			height: auto;
			/* S'assure que l'image est bien redimensionnée */
			margin: 10px 0;
		}

		.close-btn {
			background: white;
			color: black;
			border: 1px solid black;
			padding: 10px 20px;
			cursor: pointer;
			border-radius: 30px;
			margin-top: 10px;
		}

		.close-btn-t {
			background: rgb(226, 226, 226);
			color: white;
			border: grey;
			padding: 10px 20px;
			cursor: pointer;
			border-radius: 30px;
		}

		.download-btn {
			/* background: #007bff; */
			color: white;
			border: none;
			padding: 10px 20px;
			cursor: pointer;
			border-radius: 30px;
			margin-top: 10px;
		}

		button:disabled,
		button[disabled] {
			display: none;
		}
	</style>
@endsection
@section('base.body')
	<section class="bg-white overflow-hidden space position-relative bg-top-center" id="blog-sec"
		data-bg-src="{{ asset('/visitor/assets/img/bg/tour_bg_1.jpg') }}">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 offset-lg-3">
					<div class="title-area text-center"><span class="sub-title">Utilisez ce décor</span>
						<h2 class="sec-title">Choisissez votre photo</h2>
						<p class="sec-text">
							Recadrer votre photo dans le décor choisi, puis téléchargez le résultat !
						</p>
					</div>
				</div>
			</div>

			<div class="mt-5 pt-5">
				<div class="px-4 py-3 rounded shadow mb-2 bg-white" id="chooseBar" style="display: none">
					<div class="row align-items-center justify-content-center g-3">
						<div class="col-auto col-md-12">
							<label id="reselectImageBtn" style="cursor: pointer" class="th-btn style2 m-0 th-icon border text-dark"
								for="imageInput">
								<span class="">
									<span class="me-2">
										<svg xmlns="http://www.w3.org/2000/svg" fill="none" style="width: 20px; height:20px" viewBox="0 0 24 24"
											stroke-width="2" stroke="currentColor" class="mb-1">
											<path stroke-linecap="round" stroke-linejoin="round"
												d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
										</svg>
									</span>
									<span>
										Choisir une nouvelle photo
									</span>
								</span>
							</label>
						</div>
					</div>
				</div>
				<label style="cursor: pointer" class="shadow bg-white rounded mb-4" for="imageInput" id="imgLabel">
					<div style="width: 100%; height: 50vh;" class="d-flex align-items-center justify-content-center">
						<span>
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" style="width: 100px; height:100px" viewBox="0 0 24 24"
								stroke-width="1.5" stroke="currentColor" class="size-6">
								<path stroke-linecap="round" stroke-linejoin="round"
									d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
							</svg>
							<br>
							Choisissez une photo
						</span>
					</div>
				</label>
				<input type="file" hidden id="imageInput" accept="image/*">
			</div>




			<div>
				<img id="image" style="display: none;">
			</div>
			<canvas id="canvas" class="shadow bg-white rounded mb-4" width="800" height="600"
				style="display: none;"></canvas>


			<div class="mt-1 pt-1">
				<div class="px-4 py-3 rounded shadow mb-2 bg-white" id="applyDecor" style="display: none">
					<div class="row align-items-center justify-content-center g-3">
						<div class="col-auto col-md-12">
							<button id="addDecorButton" disabled class="th-btn th-icon m-0">Appliquer le décor</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal -->
			<div id="modal" class="modal">
				<div class="modal-content">
					<h4>Résultat final</h4>
					<img id="modalImage" src="" alt="Aperçu" style="object-fit: cover">
					<br>
					<div class="d-flex align-items-center">
						<button id="closeModalButton" class="close-btn me-2">Annuler</button>
						<button id="downloadButton" class="close-btn-t w-100" style="background-color: #1CA8CB">Télécharger</button>
					</div>
					<br>
				</div>
			</div>
		</div>
		</div>
	@endsection

	@push('scripts')
		<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
		<script>
			const imageInput = document.getElementById("imageInput");
			const imageElement = document.getElementById("image");
			const imageLabelElement = document.getElementById("imgLabel");
			const canvas = document.getElementById("canvas");
			const addDecorButton = document.getElementById("addDecorButton");
			const chooseBar = document.getElementById("chooseBar");
			const applyDecor = document.getElementById("applyDecor");

			const modal = document.getElementById("modal");
			const modalImage = document.getElementById("modalImage");
			const closeModalButton = document.getElementById("closeModalButton");
			const downloadButton = document.getElementById("downloadButton");

			let cropper;

			// Chargez le décor pour obtenir ses dimensions
			const decorImage = new Image();
			decorImage.src = "/storage/{{ $decor['file_path'] }}";

			decorImage.onload = () => {
				const decorWidth = decorImage.naturalWidth; // Largeur réelle du décor
				const decorHeight = decorImage.naturalHeight; // Hauteur réelle du décor
				const decorAspectRatio = decorWidth / decorHeight; // Ratio du décor

				// Configurez le canvas avec la taille exacte du décor
				canvas.width = decorWidth;
				canvas.height = decorHeight;

				imageInput.addEventListener("change", (event) => {
					const file = event.target.files[0];

					if (file) {
						const reader = new FileReader();

						reader.onload = (e) => {
							imageElement.src = e.target.result;
							imageElement.style.display = "block";
							imageLabelElement.style.display = "none";
							chooseBar.style.display = "block";
							applyDecor.style.display = "block";

							if (cropper) {
								cropper.destroy();
							}

							// Configurez le Cropper.js avec le ratio du décor
							cropper = new Cropper(imageElement, {
								aspectRatio: decorAspectRatio,
								viewMode: 1,
							});

							addDecorButton.disabled = false;
						};

						reader.readAsDataURL(file);
					}
				});

				addDecorButton.addEventListener("click", () => {
					if (cropper) {
						const canvasContext = canvas.getContext("2d");

						// Obtenez l'image recadrée avec les dimensions exactes du décor
						const croppedCanvas = cropper.getCroppedCanvas({
							width: decorWidth,
							height: decorHeight,
						});

						// Effacez le canvas
						canvasContext.clearRect(0, 0, canvas.width, canvas.height);

						// Dessinez l'image recadrée sur le canvas
						canvasContext.drawImage(croppedCanvas, 0, 0, decorWidth, decorHeight);

						// Superposez le décor sur le canvas
						canvasContext.drawImage(decorImage, 0, 0, decorWidth, decorHeight);

						// Préparez l'image finale
						const finalImage = canvas.toDataURL("image/png");
						modalImage.src = finalImage;

						// Affichez le résultat dans la modal
						modal.style.display = "flex";

						// Configurez le bouton de téléchargement
						downloadButton.addEventListener("click", () => {
							axios.put("/api/decor/use/{{ $decor['id'] }}", {}, {
									headers: {
										'Content-Type': 'application/json', // Indique que le corps est en JSON
									}
								})
								.then(response => {
									if (response.data.status == 200) {
										const a = document.createElement("a");
										a.href = finalImage;
										a.download = "image-avec-decor.png";
										a.click();
									} else {
										alert("Ce décor n'est plus utilisable")
									}
									console.log('Réponse du serveur :', response.data);
								})
								.catch(error => {
									console.error('Erreur lors de la requête PUT :', error.response
										?.data || error.message);
								});
							modal.style.display = "none";
						});
					}
				});

				closeModalButton.addEventListener("click", () => {
					modal.style.display = "none";
				});
			};
		</script>
	@endpush
