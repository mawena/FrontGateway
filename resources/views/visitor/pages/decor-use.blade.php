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
			background: #ff0000;
			color: white;
			border: none;
			padding: 10px 20px;
			cursor: pointer;
			border-radius: 5px;
			margin-top: 10px;
		}
		.close-btn-t {
			background: #007bff;
			color: white;
			border: none;
			padding: 10px 20px;
			cursor: pointer;
			border-radius: 5px;
			margin-top: 10px;
		}

		.download-btn {
			background: #007bff;
			color: white;
			border: none;
			padding: 10px 20px;
			cursor: pointer;
			border-radius: 5px;
			margin-top: 10px;
		}
	</style>
@endsection
@section('base.body')
	<h1>Recadrer une image et ajouter un décor</h1>
	<input type="file" id="imageInput" accept="image/*">
	<button id="addDecorButton" disabled>Appliquer le décor</button>
	<div>
		<img id="image" style="display: none;">
	</div>
	<canvas id="canvas" width="800" height="600" style="display: none;"></canvas>

	<!-- Modal -->
	<div id="modal" class="modal">
		<div class="modal-content">
			<h2>Résultat final</h2>
			<img id="modalImage" src="" alt="Aperçu">
			<br>
			<button id="closeModalButton" class="close-btn">Fermer</button>
			<br>
			<button id="downloadButton" class="close-btn-t">Télécharger</button>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
	<script>
		const imageInput = document.getElementById("imageInput");
		const imageElement = document.getElementById("image");
		const canvas = document.getElementById("canvas");
		const addDecorButton = document.getElementById("addDecorButton");

		const modal = document.getElementById("modal");
		const modalImage = document.getElementById("modalImage");
		const closeModalButton = document.getElementById("closeModalButton");
		const downloadButton = document.getElementById("downloadButton");

		let cropper;

		imageInput.addEventListener("change", (event) => {
			const file = event.target.files[0];

			if (file) {
				const reader = new FileReader();

				reader.onload = (e) => {
					imageElement.src = e.target.result;
					imageElement.style.display = "block";

					if (cropper) {
						cropper.destroy();
					}

					cropper = new Cropper(imageElement, {
						aspectRatio: 16 / 9,
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
				const croppedCanvas = cropper.getCroppedCanvas({
					width: 800,
					height: 450,
				});

				canvasContext.clearRect(0, 0, canvas.width, canvas.height);
				canvasContext.drawImage(croppedCanvas, 0, 0, canvas.width, canvas.height);

				const decorImage = new Image();
				decorImage.src = "/decor.png";
				decorImage.onload = () => {
					canvasContext.drawImage(decorImage, 0, 0, canvas.width, canvas.height);

					const finalImage = canvas.toDataURL("image/png");
					modalImage.src = finalImage;

					modal.style.display = "flex";

					downloadButton.addEventListener("click", () => {
						const a = document.createElement("a");
						a.href = finalImage;
						a.download = "image-avec-decor.png";
						a.click();
					});
				};
			}
		});

		closeModalButton.addEventListener("click", () => {
			modal.style.display = "none";
		});
	</script>
@endpush
