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
			    		Video
			    	</a>
			    </li>
			    <li #{MENUAUDIO}#>
			    	<a href="multimedia.php?type=audio">
			    		<i class="fa fa-music"></i>
			    		Audio
			    	</a>
			    </li>
			    <li #{MENUIMAGE}#>
			    	<a href="multimedia.php?type=image">
			    		<i class="fa fa-picture-o"></i>
			    		Imagen
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
			    <li>
			    	<a href="#" class="green">
			    		<i class="fa fa-plus-circle"></i>
			    		Subir archivo
			    	</a>
			    </li>
			</ul>
		</div>
	</div>
</nav>