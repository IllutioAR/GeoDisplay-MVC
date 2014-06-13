<?php

require '../../app/model/tag.model.php';
require '../../app/model/client.model.php';

class mvc_controller {

	// Método que valida la sesión del usuario, si la sesión no es válida redirige automáticamente al login.
	function validate_session(){
		session_start();
		if( isset($_SESSION["logged"]) && $_SESSION["logged"] ){
			return true;
		}
		header("Location: login.php");
	}

	function add_tag(){
		//Usar add_new_tag();
		if( isset($_POST["latitude"]) && 
			isset($_POST["longitude"]) && 
			isset($_POST["name"]) && 
			isset($_POST["description"]) /*&& 
			isset($_FILES["video"])*/ )
		{
			echo $_POST["latitude"];
			echo $_POST["longitude"];
			echo $_POST["name"];
			echo $_POST["description"];
		}
		else{
			header("addtag.php?error=incomplete");
		}
	}

}
?>