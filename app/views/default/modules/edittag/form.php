<div>
	<form id="form" role="form" action="ajax/edit_tag.php" method="post" enctype="multipart/form-data">
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
								<input name="latitude" type="text" class="form-control" id="latitude" value="<?= $tag['latitude'] ?>">
							</div>
							<div class="col-xs-6">
								<label for="longitude">Longitud <i class="fa fa-asterisk"></i></label>
								<input name="longitude" type="text" class="form-control" id="longitude" value="<?= $tag['longitude'] ?>">
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
								<label for="name">
									Nombre del tag
									<i class="fa fa-asterisk"></i>
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="Pon un nombre al lugar que quieres etiquetar."></i>]
								</label>
								<input name="name" type="text" class="form-control" id="name" value="<?= $tag['name'] ?>">
							</div>
							<div class="col-xs-6">
								<label for="description">
									Descripción
									<i class="fa fa-asterisk"></i>
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="Agrega una breve descripción de este lugar."></i>]
								</label>
								<textarea name="description" class="form-control" rows="2" id="description"><?= $tag['description'] ?></textarea>
							</div>
							<div class="col-xs-6">
								<label for="url">
									Sitio web
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="Dirección a tu sitio web."></i>]
								</label>
								<input name="url" type="text" class="form-control" id="url" value="<?= $tag['url'] ?>">
							</div>
							<div class="col-xs-6">
								<label for="purchase_url">
									Dirección de compra
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="Dirección para comprar un producto o servicio."></i>]
								</label>
								<input name="purchase_url" type="text" class="form-control" id="purchase_url" value="<?= $tag['url_purchase'] ?>">
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
								<label for="facebook">Facebook</label>
								<input name="facebook" type="url" class="form-control" id="facebook" value="<?= $tag['facebook'] ?>">
							</div>
							<div class="col-xs-6">
								<label for="twitter">Twitter</label>
								<input name="twitter" type="text" class="form-control" id="twitter" value="<?= $tag['twitter'] ?>">
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
						<?php 
							if( isset($tag['video_path']) )
								echo '<i id="close-video-preview" type="video" class="fa fa-times fa-lg pull-right close-icon"></i>';
						?>
					</div>
					<?php 
						if( !isset($tag['video_path']) ):
					?>
					<div id="video-field">
						<div class="form" id="multimedia">
							<div class="row" id="multimedia-video">
								<div class="col-xs-12">
									<input name="video" id="video" type="file" class="btn btn-default" style="display:none">
									<button id="btn-video" class="btn btn-default" style="margin:.2em">
										<i class="fa fa-laptop"></i> 
										Seleccionar una archivo
									</button>
								</div>
							</div>
						</div>
					</div>
					<?php
						else:
					?>
					<div id="video-field">
						<div id="video-preview">
							<div class="preview-container">
								<video class="video-preview" controls>
									<source src="<?= $tag['video_path'] ?>" type="video/mp4">
									Tu navegador no tiene soporte para HTML5.
								</video>
							</div>
						</div>
					</div>
					<?php
						endif;
					?>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="seccion">
					<div class="titulo">
						<strong>Audio</strong>
						<?php 
							if( isset($tag['audio_path']) )
								echo '<i id="close-audio-preview" type="audio" class="fa fa-times fa-lg pull-right close-icon"></i>';
						?>
					</div>
					<?php 
						if( !isset($tag['audio_path']) ):
					?>
					<div id="audio-field">
						<div class="form" id="multimedia">
							<div class="row" id="multimedia-audio">
								<div class="col-xs-12">
									<input name="audio" type="file" class="btn btn-default" style="display:none">
									<button id="btn-audio" class="btn btn-default" style="margin:.2em">
										<i class="fa fa-laptop"></i> 
										Selecciona una archivo
									</button>
								</div>
							</div>
						</div>
					</div>
					<?php
						else:
					?>
					<div id="audio-field">
						<div id="audio-preview">
							<div class="preview-container">
								<audio class="audio-preview" controls>
									<source src="<?= $tag['audio_path'] ?>" type="audio/mpeg">
									Tu navegador no tiene soporte para HTML5.
								</audio>
							</div>
						</div>
					</div>
					<?php
						endif;
					?>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="seccion">
					<div class="titulo">
						<strong>Imagen</strong>
						<?php 
							if( isset($tag['image_path']) )
								echo '<i id="close-image-preview" type="image" class="fa fa-times fa-lg pull-right close-icon"></i>';
						?>
					</div>
					<?php 
						if( !isset($tag['image_path']) ):
					?>
					<div id="image-field">
						<div class="form" id="multimedia">
							<div class="row" id="multimedia-image">
								<div class="col-xs-12">
									<input name="image" type="file" class="btn btn-default" style="display:none">
									<button id="btn-image" class="btn btn-default" style="margin:.2em">
										<i class="fa fa-laptop"></i> 
										Selecciona una archivo
									</button>
								</div>
							</div>
						</div>
					</div>
					<?php 
						else:
					?>
					<div id="image-field">
						<div id="image-preview">
							<div class="preview-container">
								<img src="<?= $tag['image_path'] ?>" alt="<?= $tag['name'] ?>" class="image-preview">
							</div>
						</div>
					</div>
					<?php 
						endif;
					?>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	$(".fa").tooltip();
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="js/map_edit.js"></script>
<script src="js/edittag.js"></script>