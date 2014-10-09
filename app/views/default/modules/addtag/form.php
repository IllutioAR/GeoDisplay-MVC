<div>
	<form id="form" role="form" action="ajax/add_tag.php" method="post" enctype="multipart/form-data">
		<div class="row" id="1">
			<div class="col-xs-12 col-md-8 col-md-offset-2">
				<div class="seccion">
					<div class="titulo">
						<strong>#{ADDTAG.TITLE-LOCATION}#</strong>
					</div>
					<input id="map-search" class="controls" type="text" placeholder="#{ADDTAG.SEARCH}#" style="display: none">
					<div id="map-canvas"></div>
					<div class="form">
						<div class="row">
							<div class="col-xs-6">
								<label for="latitude">#{ADDTAG.LATITUDE}# <i class="fa fa-asterisk"></i></label>
								<input name="latitude" type="text" class="form-control" id="latitude">
							</div>
							<div class="col-xs-6">
								<label for="longitude">#{ADDTAG.LONGITUDE}# <i class="fa fa-asterisk"></i></label>
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
						<strong>#{ADDTAG.TITLE-GENERAL}#</strong>
						<!--(Los campos con <i class="fa fa-asterisk"></i> son obligatorios)-->
					</div>
					<div class="form">
						<div class="row">
							<div class="col-xs-6">
								<label for="tag">
									#{ADDTAG.TAGNAME}#
									<i class="fa fa-asterisk"></i>
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="#{ADDTAG.TAGNAME-TOOTIP}#"></i>]
								</label>
								<input name="name" type="text" class="form-control" id="name">
							</div>
							<div class="col-xs-6">
								<label for="descripcion">
									#{ADDTAG.TAGDESC}#
									<i class="fa fa-asterisk"></i>
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="#{ADDTAG.TAGDESC-TOOLTIP}#"></i>]
								</label>
								<textarea name="description" class="form-control" rows="2" id="description"></textarea>
							</div>
							<div class="col-xs-6">
								<label for="tag">
									<i class="fa fa-globe"></i>
									#{ADDTAG.WEBSITE}#
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="#{ADDTAG.WEBSITE-TOOLTIP}#"></i>]
								</label>
								<input name="url" type="text" class="form-control" id="website_url">
							</div>
							<div class="col-xs-6">
								<label for="tag">
									<i class="fa fa-shopping-cart"></i>
									#{ADDTAG.PURCHASEURL}#
									[<i class="fa fa-question" data-toggle="tooltip" data-placement="top" title="#{ADDTAG.PURCHASEURL-TOOLTIP}#"></i>]
								</label>
								<input name="purchase_url" type="text" class="form-control" id="purchase_url">
							</div>
						</div>
					</div>
				</div>
				<div class="seccion">
					<div class="titulo">
						<strong>#{ADDTAG.TITLE-SOCIAL}#</strong>
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
						<strong>#{ADDTAG.TITLE-IMAGE}#</strong>
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
										#{ADDTAG.DRAG-IMAGE}#
									</div>
									<div>
									 .jpg .png .gif (Max 2MB) 
									</div>
								</div>
							</div>
						</div>
						<div class="button-area">
							<button id="image-select-pc" class="btn btn-default">#{ADDTAG.UPLOAD-PC}#</button>
							<button id="image-select-cloud" class="btn btn-default">#{ADDTAG.UPLOAD-CLOUD}#</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="seccion">
					<div class="titulo">
						<strong>#{ADDTAG.TITLE-VIDEO}#</strong>
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
										#{ADDTAG.DRAG-VIDEO}#
									</div>
									<div>
									 .mp4 .3gp (Max 30MB) 
									</div>
								</div>
							</div>
						</div>
						<div class="button-area">
							<button id="video-select-pc" class="btn btn-default">#{ADDTAG.UPLOAD-PC}#</button>
							<button id="video-select-cloud" class="btn btn-default">#{ADDTAG.UPLOAD-CLOUD}#</button>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-4">
				<div class="seccion">
					<div class="titulo">
						<strong>#{ADDTAG.TITLE-AUDIO}#</strong>
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
										#{ADDTAG.DRAG-AUDIO}#
									</div>
									<div>
									 .mp3 (Max 10MB) 
									</div>
								</div>
							</div>
						</div>
						<div class="button-area">
							<button id="audio-select-pc" class="btn btn-default">#{ADDTAG.UPLOAD-PC}#</button>
							<button id="audio-select-cloud" class="btn btn-default">#{ADDTAG.UPLOAD-CLOUD}#</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>