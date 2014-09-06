<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>Iniciar sesión - GeoDisplay</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
		<link href="css/geodisplay.css" rel="stylesheet">
		<link href="css/login.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<header>
			<nav class="navbar navbar-default navbar-static-top" role="navigation">
				<div class="container-fluid" id="menu">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-top">
					    	<span class="sr-only"></span>
						    <span class="icon-bar"></span>
						    <span class="icon-bar"></span>
						    <span class="icon-bar"></span>
						</button>
						<a id="logo" class="navbar-brand" href="index.php">
							<img src="img/logo-124x124.png" height="40" width="40">
							<span>GeoDisplay</span>
						</a>
					</div>
				</div><!-- /.container-fluid -->
			</nav>
		</header>
		<div class="backgroundImage">
            <div id="map" class="backgroundImage"></div>
        </div>
		<div class="container">
			<div>
				<div class="row">
					<div class="col-xs-12 col-md-6 col-md-offset-3">
						<div class="seccion">
							<div class="row">
								<div class="col-xs-12">
									<div class="titulo-login">
										<h2>Registrate en GeoDisplay</h2>
									</div>
									<hr>
								</div>
								<div>
	                                <form action="register.php" method="post" role="form" enctype="multipart/form-data">
	                                	<div class="col-xs-6">
	                                		<div class="form-group">
												<label for="nick">Nick</label>
												<input name="nick" type="text" class="form-control" id="nick" pattern="[a-zA-Z0-9]" title="El nick sólo debe tener letras o números." placeholder="Escribe un nick" required focus>
											</div>
		                            		<div class="form-group">
												<label for="email">Correo electrónico</label>
												<input name="email" type="email" class="form-control" id="email" placeholder="Escribe tu correo electrónico." required>
											</div>
											<div class="form-group">
												<label for="password">Contraseña</label>
												<input name="password" type="password" class="form-control" id="password" pattern=".{6,}" title="Mínimo 6 caracteres." placeholder="Escribe tu contraseña" required>
											</div>
											<div class="form-group">
												<label for="password2">Confirmar contraseña</label>
												<input name="password2" type="password" class="form-control" id="password2" pattern=".{6,}" title="Mínimo 6 caracteres." placeholder="Escribe de nuevo tu contraseña." required>
											</div>
										</div>
										<div class="col-xs-6">
											<div class="form-group">
												<label for="name">Nombre</label>
												<input name="name" type="text" class="form-control" id="name" placeholder="Escribe tu nombre" required>
											</div>
											<div class="form-group">
												<label for="logo">Logo</label>
												<input name="logo" type="file" class="form-control" id="logo">
											</div>
											<div class="form-group">
												<label for="country">Country</label>
												<select name="country" class="form-control" id="country" required>
													<option value="">---</option>
													<option value="Mexico">México</option>
													<option value="United States">Estados Unidos</option>
													<option value="United Kingdom">Reino Unido</option>
												</select>
											</div>
											<div class="form-group">
												<label for="city">City</label>
												<input name="city" type="text" class="form-control" id="city" required>
											</div>
											<div class="form-group">
												<button type="submit" class="btn btn-primary" style="width: 100%">Registrar</button>
											</div>
										</div>
	                                </form>
	                            </div>
                        	</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--
		<footer class="container login-footer">
			<span class="pull-left">illut.io</span>
			<span class="pull-left">Reporta un problema</span>
			<span class="pull-left">Ayuda</span>
			<span class="pull-right">copyright © illut.io</span>
		</footer>
		-->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
        <script>
            var map;
            var initialLocation;

            function initialize() {
                var mapOptions = {
                    disableDefaultUI: true,
                    draggable: false,
                    scrollWheel: false,
                    zoom: 14
                };
                map = new google.maps.Map(document.getElementById("map"),
                      mapOptions);
                //W3C Geolocation
                if(navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                      initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
                      map.setCenter(initialLocation);
                    }, function(){
                      handleNoGeolocation();
                    });
                }
                //Browser doesn't support Geolocation
                else{
                    handleNoGeolocation();
                }

                function handleNoGeolocation() {
                    var newyork = new google.maps.LatLng(40.69847032728747, -73.9514422416687);
                    map.setCenter(newyork);
                }
            }//Finish initialize
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
	</body>
</html>