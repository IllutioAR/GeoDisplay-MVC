<?php
require '../app/controller/mvc.controller.php';

$mvc = new mvc_controller();
if ( isset( $_GET["tags"] ) && $_GET["tags"] == "inactive" ) {
	$mvc->show_tags(0);	
}
else if( isset( $_GET["tags"] ) && $_GET["tags"] == "active" ){
	$mvc->show_tags(1);
}
elseif ( !isset($_GET["tags"]) ) {
	$mvc->show_tags(1);
}
else{
	$mvc->show_tags(1);
}


/*
else if($_GET['a'] == 'login'){
	if( isset($_SESSION['logged']) && $_SESSION['logged'] ){
		header("location: index.php?a=tags");
	}
	else{
		$mvc->login();
	}
}
*/

/*
else if( isset($_POST['carrera']) && isset($_POST['cantidad']) ){
	$mvc->buscar( $_POST['carrera'], $_POST['cantidad'] );
}
else{
	$mvc->principal();
}
*/

?>