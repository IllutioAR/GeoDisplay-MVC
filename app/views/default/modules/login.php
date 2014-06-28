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
						<a id="logo" class="navbar-brand" href="index.html">
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
					<div class="col-xs-12 col-md-4 col-md-offset-4">
						<div class="seccion">
							<div class="titulo-login">
								<h2>GeoDisplay</h2>
							</div>
							<hr>
							<div>
                                <form action="login.php" method="post" role="form">
                            		<div class="form-group">
										<label for="email">Correo electrónico</label>
										<input name="email" type="email" class="form-control" id="email" placeholder="Escribe tu correo electrónico" required focus>
									</div>
									<div class="form-group">
										<label for="password">Contraseña</label>
										<input name="password" type="password" class="form-control" id="password" placeholder="Escribe tu contraseña" required>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary" style="width: 100%">Iniciar sesión</button>
									</div>
									<span class="pass-recovery-container">
										<a id="passwordRecovery" class="pass-recovery pull-right">Olvidé mi contraseña</a>
									</span>
                                </form>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer class="container login-footer">
			<span class="pull-left">illut.io</span>
			<span class="pull-left">Reporta un problema</span>
			<span class="pull-left">Ayuda</span>
			<span class="pull-right">copyright © illut.io</span>
		</footer>
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
                    zoom: 11
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
        <script>
        	$("#passwordRecovery").click(function (){
        		var email = $("#email").val();
        		var data = {"email" : email};
				$.ajax({
			        data:  data,
			        url:   'ajax/passwordRecovery.php',
			        type:  'post',
			        beforeSend: function (){
			            console.log("Procesando, espere por favor...");
			        },
			        success: function (response){
			            console.log("Servidor: " + response);
			            //location.reload();
			        },
			        fail: function(){
			        	console.log("Error:");
			        }
			    });
        	});
        </script>
	</body>
</html>