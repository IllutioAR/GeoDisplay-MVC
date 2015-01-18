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
					<a href="gif.php">
						#{GIF.ACTIVE}#
						<span class="badge">#{NUMACTIVE}#</span>
					</a>
				</li>
				<li style="padding:8px">
					<form class="form-inline" role="form">
						<div class="form-group">
							<input id="search_tag" type="text" placeholder="#{GIF.SEARCH-PLACEHOLDER}#" class="form-control">
							<button id="search_button" class="btn btn-default"><span class="fa fa-search"></span></button>
						</div>
					</form>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="addgif.php" class="green">
						<i class="fa fa-plus-circle"></i>
						#{GIF.ADDGIF}#
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>