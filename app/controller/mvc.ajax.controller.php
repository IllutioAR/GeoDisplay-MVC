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
		$this->validate_session();
		if( $_POST["latitude"] != "" && $_POST["longitude"] != "" && $_POST["name"] != "" && $_POST["description"] != "" && isset($_FILES["video"]) )
		{
			$tag = new tag();
			$tag->add_new_tag($_SESSION["client"]["nick"], $_SESSION["client"]["tags"], $_SESSION["client"]["space"]);
		}
		else{
			header("Location: ../addtag.php?error=incomplete");
		}
	}

	function enable_tag(){
		$this->validate_session();
		$tag = new tag();
		$tag->enable_tag($_SESSION["client"]["nick"], $_POST["id"]);
	}

	function clone_tag(){
		$this->validate_session();
		$tag = new tag();
		$tag->clone_tag($_SESSION["client"]["nick"], $_POST["id"]);	
	}

	function delete_tag(){
		$this->validate_session();
		$tag = new tag();
		$tag->delete_tag($_SESSION["client"]["nick"], $_POST["id"]);	
	}

	function password_recovery(){
		require '../../app/model/client.model.php';
		$client = new client();
		if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
			$client->password_recovery($_POST["email"]);
		}
	}

}
?>