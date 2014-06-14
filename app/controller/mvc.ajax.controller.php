<?php

require '../../app/model/tag.model.php';

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
			isset($_POST["description"]) && 
			isset($_FILES["video"]) )
		{
			$tag = new tag();
			$tag->add_new_tag();
		}
		else{
			echo "No hay datos";
			header("addtag.php?error=incomplete");
		}
	}

}
?>