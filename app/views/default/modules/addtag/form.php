<div>
	<form id="form" role="form" action="ajax/add_tag.php" method="post" enctype="multipart/form-data">
		<div class="row" id="1">
			<div class="col-xs-12 col-md-8 col-md-offset-2">
				<div class="seccion">
					<div class="titulo">
						<strong>Localiza un punto</strong>
					</div>
					<div id="map-canvas"></div>
					<div class="form">
						<div class="row">
							<div class="col-xs-6">
								<label for="latitude">Latitud <i class="fa fa-asterisk"></i></label>
								<input name="latitude" type="text" class="form-control" id="latitude">
							</div>
							<div class="col-xs-6">
								<label for="longitude">Longitud <i class="fa fa-asterisk"></i></label>
								<input name="longitude" type="text" class="form-control" id="longitude">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="2" style="display:none">
			<div class="col-xs-12 col-md-8 col-md-offset-2">
				<div class="seccion">
					<div class="titulo">
						<strong>Información general</strong>
						(Los campos con <i class="fa fa-asterisk"></i> son obligatorios)
					</div>
					<div class="form">
						<div class="row">
							<div class="col-xs-6">
								<label for="tag">
									Nombre del lugar
									<i class="fa fa-asterisk"></i>
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="Pon un nombre al lugar que quieres etiquetar."></i>]
								</label>
								<input name="name" type="text" class="form-control" id="name">
							</div>
							<div class="col-xs-6">
								<label for="descripcion">
									Descripción
									<i class="fa fa-asterisk"></i>
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="Agrega una breve descripción de este lugar."></i>]
								</label>
								<textarea name="description" class="form-control" rows="2" id="description"></textarea>
							</div>
							<div class="col-xs-6">
								<label for="tag">
									<i class="fa fa-globe"></i>
									Sitio web
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="Dirección a tu sitio web."></i>]
								</label>
								<input name="url" type="text" class="form-control" id="tag">
							</div>
							<div class="col-xs-6">
								<label for="tag">
									<i class="fa fa-shopping-cart"></i>
									Url de compra
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="Dirección web para comprar un producto o servicio."></i>]
								</label>
								<input name="purchase_url" type="text" class="form-control" id="tag">
							</div>
						</div>
					</div>
				</div>
				<div class="seccion">
					<div class="titulo">
						<strong>Redes sociales</strong>
					</div>
					<div class="form">
						<div class="row">
							<div class="col-xs-6">
								<label for="facebok">
									<i class="fa fa-facebook-square"></i>
									Facebook
								</label>
								<input name="facebook" type="url" class="form-control" id="facebook">
							</div>
							<div class="col-xs-6">
								<label for="twitter">
									<i class="fa fa-twitter"></i>
									Twitter
								</label>
								<input name="twitter" type="text" class="form-control" id="twitter">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="3" style="display:none">
			<div class="col-xs-12 col-md-4">
				<div class="seccion">
					<div class="titulo">
						<strong>Imagen</strong>
						<i class="fa fa-asterisk"></i>
					</div>
					<div class="multimedia-container">
						<input name="image" id="image" type="file" style="display:none">
						<div class="drag-area" gd-type="image">
							<div class="parent-container">
								<div class="child-container">
									<div>
										<i class="fa fa-picture-o icon-lg" data-original-title="" title=""></i>
									</div>
									<div class="text-lg">
										Arrastra una imagen aquí
									</div>
								</div>
							</div>
						</div>
						<div class="button-area">
							<button id="image-select-pc" class="btn btn-default">Subir desde PC</button>
							<button id="image-select-cloud" class="btn btn-default">Image en GeoDisplay</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="seccion">
					<div class="titulo">
						<strong>Video</strong>
					</div>
					<div class="multimedia-container">
						<input name="video" id="video" type="file" style="display:none">
						<div class="drag-area" gd-type="video">
							<div class="parent-container">
								<div class="child-container">
									<div>
										<i class="fa fa-film icon-lg" data-original-title="" title=""></i>
									</div>
									<div class="text-lg">
										Arrastra un video aquí
									</div>
								</div>
							</div>
						</div>
						<div class="button-area">
							<button id="video-select-pc" class="btn btn-default">Subir desde PC</button>
							<button id="video-select-cloud" class="btn btn-default">Video en GeoDisplay</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="seccion">
					<div class="titulo">
						<strong>Audio</strong>
					</div>
					<div class="multimedia-container">
						<input name="audio" id="audio" type="file" style="display:none">
						<div class="drag-area" gd-type="audio">
							<div class="parent-container">
								<div class="child-container">
									<div>
										<i class="fa fa-music icon-lg" data-original-title="" title=""></i>
									</div>
									<div class="text-lg">
										Arrastra un audio aquí
									</div>
								</div>
							</div>
						</div>
						<div class="button-area">
							<button id="audio-select-pc" class="btn btn-default">Subir desde PC</button>
							<button id="audio-select-cloud" class="btn btn-default">Audio en GeoDisplay</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>