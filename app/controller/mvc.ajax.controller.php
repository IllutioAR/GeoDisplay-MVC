<?php

require '../../app/model/tag.model.php';
require '../../app/model/multimedia.model.php';

class mvc_controller {

	// Método que valida la sesión del usuario, si la sesión no es válida redirige automáticamente al login.
	function validate_session(){
		session_start();
		if( isset($_SESSION["logged"]) && $_SESSION["logged"] ){
			return true;
		}
		header("Location: login.php");
	}

	/*
		TAGS
	*/

	function add_tag(){
		$this->validate_session();
		if( strlen($_POST["latitude"]) > 0 && 
			strlen($_POST["longitude"]) > 0 && 
			strlen($_POST["name"]) > 0 && 
			strlen($_POST["description"]) > 0 &&
			( isset($_FILES["video"]) || isset($_POST["video_id"]) )
		  )
		{
			$tag = new tag($_SESSION["client"]["nick"]);
			$tag->add_new_tag($_SESSION["client"]["tags"], $_SESSION["client"]["space"]);
			header("Location: ../index.php?success=new_tag");
		}
		else{
			header("Location: ../addtag.php?error=incomplete");
		}
	}

	function edit_tag(){
		$this->validate_session();
		if( strlen($_POST["latitude"]) > 0 && 
			strlen($_POST["longitude"]) > 0 && 
			strlen($_POST["name"]) > 0 && 
			strlen($_POST["description"]) > 0
		  )
		{
			$tag = new tag($_SESSION["client"]["nick"]);
			$tag->edit_tag($_SESSION["client"]["space"]);
			header("Location: ../index.php?success=edit_tag");
		}
		else{
			header("Location: ../index.php?error=edit_incomplete");
		}	
	}

	function enable_tag(){
		$this->validate_session();
		$tag = new tag($_SESSION["client"]["nick"]);
		$tag->enable_tag($_POST["id"]);
	}

	function clone_tag(){
		$this->validate_session();
		$tag = new tag($_SESSION["client"]["nick"]);
		$tag->clone_tag($_POST["id"]);	
	}

	function delete_tag(){
		$this->validate_session();
		$tag = new tag($_SESSION["client"]["nick"]);
		$tag->delete_tag($_POST["id"]);	
	}

	/*
		MULTIMEDIA
	*/

	function delete_file(){
		$this->validate_session();
		$multimedia = new multimedia($_SESSION["client"]["nick"]);
		$multimedia->delete_file($_POST["id"]);
	}

	function get_user_files(){
		$this->validate_session();
		if( isset($_GET["type"]) ){
			$multimedia = new multimedia($_SESSION["client"]["nick"]);
			$files["files"] = $multimedia->get_form_files( $_GET["type"] );
			echo json_encode($files);
		}
		
	}

	function upload_file(){
		$this->validate_session();
		$multimedia = new multimedia($_SESSION["client"]["nick"]);
		echo $multimedia->save_file( $_GET["type"] );
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