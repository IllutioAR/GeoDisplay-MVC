<nav id="menu-secundario" class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
				<span class="sr-only"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse" id="navbar-menu">
			<ul class="nav navbar-nav">
				<li #{MENUVIDEO}#>
					<a href="multimedia.php?type=video">
						<i class="fa fa-film"></i>
						#{MULTIMEDIA.MENU-VIDEO}#
					</a>
				</li>
				<li #{MENUAUDIO}#>
					<a href="multimedia.php?type=audio">
						<i class="fa fa-music"></i>
						#{MULTIMEDIA.MENU-AUDIO}#
					</a>
				</li>
				<li #{MENUIMAGE}#>
					<a href="multimedia.php?type=image">
						<i class="fa fa-picture-o"></i>
						#{MULTIMEDIA.MENU-IMAGE}#
					</a>
				</li>
				<!--
				<li #{MENURENDER}#>
					<a href="#">
						<i class="fa fa-cube"></i>
						3D Render
					</a>
				</li>
				-->
				<li style="padding:8px">
					<form class="form-inline" role="form">
						<div class="form-group">
							<input id="search_file" type="text" placeholder="#{MULTIMEDIA.SEARCH-PLACEHOLDER}#" class="form-control">
							<button id="search_button" class="btn btn-default"><span class="fa fa-search"></span></button>
						</div>
					</form>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">

				<!--
				<li>
					<a href="#">
						<i class="fa fa-shopping-cart"></i>
						Store
					</a>
				</li>
				-->

				<li class="dropdown">
					<form id="upload-file" action="ajax/upload_file.php" method="post" enctype="multipart/form-data" style="display:none">
						<input id="file" name="file" type="file">
					</form>
					<a id="file-upload-select" href="#" class="green dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-plus-circle"></i>
						#{MULTIMEDIA.UPLOADFILE}#
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>
							<a id="video-upload" href="#">
								<i class="fa fa-film"></i>
								#{MULTIMEDIA.MENU-VIDEO}#
							</a>
						</li>
						<li>
							<a id="audio-upload" href="#">
								<i class="fa fa-music"></i>
								#{MULTIMEDIA.MENU-AUDIO}#
							</a>
						</li>
						<li>
							<a id="image-upload" href="#">
								<i class="fa fa-picture-o"></i>
								#{MULTIMEDIA.MENU-IMAGE}#
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>