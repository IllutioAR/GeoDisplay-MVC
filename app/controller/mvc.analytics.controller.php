<?php

require '../app/model/analytics.model.php';

class mvc_controller {

	// Método que valida la sesión del usuario, si la sesión no es válida redirige automáticamente al login.
	function validate_session(){
		session_start();
		if( isset($_SESSION["logged"]) && $_SESSION["logged"] ){
			return true;
		}
		header("Location: login.php");
	}

	function analytics(){
		echo "Hola mundo!";
	}

	function get_users_data(){

	}

	function get_tags_data(){

	}

}
?>