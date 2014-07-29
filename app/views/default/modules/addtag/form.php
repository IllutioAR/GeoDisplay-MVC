<div>
	<form id="form" role="form" action="ajax/add_tag.php" method="post" enctype="multipart/form-data">
		<div id="1" class="row">
			<div class="col-xs-12 col-md-6">
				<div class="seccion">
					<div class="titulo">
						<strong>Información de geolocalización</strong>
					</div>
					<div id="map"></div>
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
			<div class="col-xs-12 col-md-6">
				<div class="seccion">
					<div class="titulo">
						<strong>Informacion general</strong>
					</div>
					<div class="form">
						<div class="row">
							<div class="col-xs-6">
								<label for="tag">
									Nombre del tag
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
									Sitio web
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="Dirección a tu sitio web."></i>]
								</label>
								<input name="url" type="text" class="form-control" id="tag">
							</div>
							<div class="col-xs-6">
								<label for="tag">
									Dirección de compra
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="Dirección para comprar un producto o servicio."></i>]
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
								<label for="facebok">Facebook</label>
								<input name="facebook" type="url" class="form-control" id="facebook">
							</div>
							<div class="col-xs-6">
								<label for="twitter">Twitter</label>
								<input name="twitter" type="text" class="form-control" id="twitter">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="2" class="row" style="display:none">
			<div class="col-xs-12 col-md-4">
				<div class="seccion">
					<div class="titulo">
						<strong>Video</strong>
						<i class="fa fa-asterisk"></i>
						<i id="close-video-select" type="video" class="fa fa-times fa-lg pull-right close-icon" style="display:none"></i>
					</div>
					<div class="form" id="multimedia">
						<div class="row" id="multimedia-video" style="margin-bottom:0">
							<div class="col-xs-12">
								<input name="video" id="video" type="file" style="display:none">
								<button id="btn-video" class="btn btn-default">
									<i class="fa fa-laptop"></i> 
									Seleccionar desde equipo
								</button>
								<button id="btn-video-cloud" class="btn btn-default">
									<i class="fa fa-cloud"></i> 
									Seleccionar de multimedia
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="seccion">
					<div class="titulo">
						<strong>Audio</strong>
						<i id="close-audio-select" type="audio" class="fa fa-times fa-lg pull-right close-icon" style="display:none"></i>
					</div>
					<div class="form" id="multimedia">
						<div class="row" id="multimedia-audio" style="margin-bottom:0">
							<div class="col-xs-12">
								<input name="audio" id="audio" type="file" style="display:none">
								<button id="btn-audio" class="btn btn-default">
									<i class="fa fa-laptop"></i> 
									Seleccionar desde equipo
								</button>
								<button id="btn-audio-cloud" class="btn btn-default">
									<i class="fa fa-cloud"></i> 
									Seleccionar de multimedia
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="seccion">
					<div class="titulo">
						<strong>Imagen</strong>
						<i id="close-image-select" type="image" class="fa fa-times fa-lg pull-right close-icon" style="display:none"></i>
					</div>
					<div class="form" id="multimedia">
						<div class="row" id="multimedia-image" style="margin-bottom:0">
							<div class="col-xs-12">
								<input name="image" id="image" type="file" style="display:none">
								<button id="btn-image" class="btn btn-default">
									<i class="fa fa-laptop"></i> 
									Seleccionar desde equipo
								</button>
								<button id="btn-image-cloud" class="btn btn-default">
									<i class="fa fa-cloud"></i> 
									Seleccionar de multimedia
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>