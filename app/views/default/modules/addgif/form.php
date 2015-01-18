<div>
	<form id="form" role="form" action="ajax/add_gif.php" method="post" enctype="multipart/form-data">
		<div class="row" id="1">
			<div class="col-xs-12 col-md-8 col-md-offset-2">
				<div class="seccion">
					<div class="titulo">
						<strong>#{ADDGIF.TITLE-LOCATION}#</strong>
					</div>
					<input id="map-search" class="controls" type="text" placeholder="#{ADDGIF.SEARCH}#" style="display: none">
					<div id="map-canvas"></div>
					<div class="form">
						<div class="row">
							<div class="col-xs-6">
								<label for="latitude">#{ADDGIF.LATITUDE}# <i class="fa fa-asterisk"></i></label>
								<input name="latitude" type="text" class="form-control" id="latitude">
							</div>
							<div class="col-xs-6">
								<label for="longitude">#{ADDGIF.LONGITUDE}# <i class="fa fa-asterisk"></i></label>
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
						<strong>#{ADDGIF.TITLE-DETAILS}#</strong>
					</div>
					<div class="form">
						<div class="row">
							<div class="col-xs-6">
								<label for="name">#{ADDGIF.NAME}# <i class="fa fa-asterisk"></i></label>
								<input name="name" id="name" type="text" class="form-control">
							</div>
							<div class="col-xs-6">
								<label for="category">#{ADDGIF.SELECT-FILE}# <i class="fa fa-asterisk"></i></label>
								<div class="input-group" id="file-selector-gif">
									<span class="input-group-btn">
										<span class="btn btn-primary btn-file">
											#{ADDGIF.SELECT}# <input id="gif_image" name="gif_image" type="file" onchange="return ShowImagePreview(this.files);" required>
										</span>
									</span>
									<input type="text" class="form-control" readonly="" value="#{ADDGIF.SELECTPLACEHOLDER}#">
								</div>
							</div>
							<div class="col-xs-12">
								<canvas id="preview-canvas"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>