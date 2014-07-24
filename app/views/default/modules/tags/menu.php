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
			    <li #{ACTIVE}#>
			    	<a href="index.php">
			    		Activos
			    		<span class="badge">#{NUMACTIVE}#</span>
			    	</a>
			    </li>
			    <li #{INACTIVE}#>
			    	<a href="index.php?tags=inactive">
			    		Inactivos
			    		<span class="badge">#{NUMINACTIVE}#</span>
			    	</a>
			    </li>
			    <li style="padding:8px">
			    	<form class="form-inline" role="form">
  						<div class="form-group">
			    			<input id="search_tag" type="text" placeholder="Busca un lugar" class="form-control">
			    			<button id="search_button" class="btn btn-default"><span class="fa fa-search"></span></button>
			    		</div>
			    	</form>
			    </li>
			    <!--
			    <li>
			    	<form class="navbar-form navbar-left">
						<div class="form-group">
							Show:
							<select id="tags" class="form-control">
								<option>1 - 9</option>
								<option>10 - 18</option>
								<option>19 - 27</option>
							</select>
						</div>
			    	</form>
			    </li>
				-->
			</ul>
			<ul class="nav navbar-nav navbar-right">
			    <li>
			    	<a href="addtag.php" class="green">
			    		<i class="fa fa-plus-circle"></i>
			    		Agregar lugar
			    	</a>
			    </li>
			</ul>
		</div>
	</div>
</nav>