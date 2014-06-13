<div>
	<form id="form" role="form" action="ajax/addtag.php" method="post">
		<div id="1" class="row">
			<div class="col-xs-12 col-md-8 col-md-offset-2">
				<div class="seccion">
					<div class="titulo">
						<strong>Geolocation information</strong>
					</div>
					<div id="map"></div>
					<div class="form">
						<div class="row">
							<div class="col-xs-6">
								<label for="latitude">Latitude <i class="fa fa-asterisk"></i></label>
								<input name="latitude" type="text" class="form-control" id="latitude" pattern="-?\d+\.\d+" title="Enter a decimal number." required>
							</div>
							<div class="col-xs-6">
								<label for="longitude">Longitude <i class="fa fa-asterisk"></i></label>
								<input name="longitude" type="text" class="form-control" id="longitude" pattern="-?\d+\.\d+" title="Enter a decimal number." required>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="2" class="row" style="display:none">
			<div class="col-xs-12 col-md-8 col-md-offset-2">
				<div class="seccion">
					<div class="titulo">
						<strong>General information</strong>
					</div>
					<div class="form">
						<div class="row">
							<div class="col-xs-6">
								<label for="tag">
									Tag name
									<i class="fa fa-asterisk"></i>
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="Name the place you want to tag."></i>]
								</label>
								<input name="name" type="text" class="form-control" id="tag" required>
							</div>
							<div class="col-xs-6">
								<label for="descripcion">
									Description
									<i class="fa fa-asterisk"></i>
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="Say something about this place."></i>]
								</label>
								<textarea name="description" class="form-control" rows="2" id="descripcion" required>
								</textarea>
							</div>
							<div class="col-xs-6">
								<label for="tag">
									URL
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="A link to your website."></i>]
								</label>
								<input name="url" type="text" class="form-control" id="tag">
							</div>
							<div class="col-xs-6">
								<label for="tag">
									Purchase URL
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="A link to buy a product or service."></i>]
								</label>
								<input name="purchase_url" type="text" class="form-control" id="tag">
							</div>
						</div>
					</div>
				</div>
				<div class="seccion">
					<div class="titulo">
						<strong>Social media</strong>
					</div>
					<div class="form">
						<div class="row">
							<div class="col-xs-6">
								<label for="facebok">Facebook</label>
								<input name="facebook" type="url" class="form-control" id="facebook" pattern="https?:\/\/(www\.)?facebook\.com(\/.*)?" title="Enter a valid facebook url (http://facebook.com/page)." placeholder="http://facebook.com/username">
							</div>
							<div class="col-xs-6">
								<label for="twitter">Twitter</label>
								<input name="twitter" type="text" class="form-control" id="twitter" pattern="\@(\d|\w|\_|)+" title="Enter a valid username." placeholder="@username">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="3" class="row" style="display:none">
			<div class="col-xs-12 col-md-4">
				<div class="seccion">
					<div class="titulo">
						<strong>Video</strong>
					</div>
					<div class="form" id="multimedia">
						<div class="row" id="multimedia-video">
							<div class="col-xs-12">
								<input name="video" id="video" type="file" class="btn btn-default" style="display:none">
								<button id="btn-video" class="btn btn-default" style="margin:.2em">
									<i class="fa fa-laptop"></i> 
									Select file
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
					</div>
					<div class="form" id="multimedia">
						<div class="row" id="multimedia-audio">
							<div class="col-xs-12">
								<input name="audio" type="file" class="btn btn-default" style="display:none">
								<button id="btn-audio" class="btn btn-default" style="margin:.2em">
									<i class="fa fa-laptop"></i> 
									Select file
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="seccion">
					<div class="titulo">
						<strong>Image</strong>
					</div>
					<div class="form" id="multimedia">
						<div class="row" id="multimedia-image">
							<div class="col-xs-12">
								<input name="image" type="file" class="btn btn-default" style="display:none">
								<button id="btn-image" class="btn btn-default" style="margin:.2em">
									<i class="fa fa-laptop"></i> 
									Select file
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input id="upload" type="submit" style="display:none" value="Submit">
	</form>
</div>
<script>
	$(".fa").tooltip();
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script src="js/map.js"></script>
<script src="js/addtag.js"></script>