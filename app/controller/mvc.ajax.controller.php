<?php

require '../../app/model/tag.model.php';
require '../../app/model/multimedia.model.php';
require '../../app/model/client.model.php';

class mvc_controller {

	// Método que valida la sesión del usuario, si la sesión no es válida redirige automáticamente al login.
	function validate_session(){
		session_start();
		if( isset($_SESSION["logged"]) && $_SESSION["logged"] && isset($_SESSION["client"]) ){
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
			( isset($_POST["image-id"]) )
		  )
		{
			$tag = new tag($_SESSION["client"]["nick"]);
			$tag->add_new_tag($_SESSION["client"]["tags"], $_SESSION["client"]["space"]);
			$_SESSION["success"]["new_tag"] = true;
			header("Location: ../index.php");
		}
		else{
			$_SESSION["error"]["incomplete_tag"] = true;
			header("Location: ../addtag.php");
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
			$_SESSION["success"]["edit_tag"] = true;
			header("Location: ../index.php");
		}
		else{
			$_SESSION["error"]["edit_incomplete"] = true;
			header("Location: ../index.php");
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

	function get_file_by_id(){
		$this->validate_session();
		if( isset($_GET["id"]) ){
			$multimedia = new multimedia($_SESSION["client"]["nick"]);
			$file["file"] = $multimedia->get_file_by_id( $_GET["id"] );
			echo json_encode($file);
		}
		
	}

	function upload_file(){
		$this->validate_session();
		$multimedia = new multimedia($_SESSION["client"]["nick"]);
		echo $multimedia->save_file( $_GET["type"] );
	}

	function change_logo(){
		$this->validate_session();
		if( isset($_FILES["logo"]) && $_FILES["logo"]["error"] === 0 ){

			$valid_exts = array("jpeg", "jpg", "png");
			$ext = strtolower(pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION));
			//Si el archivo no tiene una extensión válida termina la función
			if( !in_array($ext, $valid_exts) ){
				return;
			}

			$path = "../media/".$_SESSION["client"]["nick"]."/image/";

			while( file_exists( $path.$_FILES["logo"]["name"] ) ){
				$path = $path."(".uniqid().")";
			}
			$path = $path.$_FILES["logo"]["name"];
			
			if ( move_uploaded_file($_FILES["logo"]["tmp_name"], $path) ) {
				
				$tmp_path = str_replace("../", "", $path);

				$client = new client();
				$client->change_logo($_SESSION["client"]["email"], $tmp_path);

				unlink("../".$_SESSION["client"]["logo"]);
				$_SESSION["client"]["logo"] = $tmp_path;
				
				$_SESSION["success"]["file_upload"] = true;
			}
			else{
				$_SESSION["error"]["file_upload"] = true;
			}



			
		}
	}

	function change_language(){
		$this->validate_session();
		if( isset($_POST["language"]) ){
			if( $_POST["language"] != "" ){
				$client = new client();
				$client->change_language($_SESSION["client"]["email"], $_POST["language"]);
				$_SESSION["client"]["language"] = $_POST["language"];	
			}
		}
	}

	function change_password(){
		$this->validate_session();
		if( isset($_POST["password"]) && isset($_POST["new_password"]) && isset($_POST["new_password_confirm"]) ){
			
			if( $_POST["new_password"] === $_POST["new_password_confirm"] ){
				
				$client = new client();
				$hashed_password = $client->get_hashed_password($_SESSION["client"]["email"]);
				
				if(crypt($_POST["password"], $hashed_password) == $hashed_password){
					if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH){

				        $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);

				        $new_hashed_password = crypt($_POST["new_password"], $salt);
				        $client->change_password($_SESSION["client"]["email"], $new_hashed_password);
						
						$_SESSION["success"]["change_password"] = true;
						header("Location: ../profile.php?success");
						exit();
				    }
				}
			}
		}
		$_SESSION["error"]["change_password"] = true;
		header("Location: ../profile.php?error");
	}

	function password_recovery(){
		if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
			$client = new client();
			if($client->user_exists("",$_POST["email"])){
				$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
				$new_password = "";
				for ($i = 0; $i < 10; $i++) {
					$new_password .= $characters[rand(0, strlen($characters) - 1)];
				}
				if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH){
					$salt = "$2y$11$" . substr(md5(uniqid(rand(), true)), 0, 22);
					$hashed_password = crypt($new_password, $salt);
				
					$client->password_recovery($_POST["email"], $hashed_password);

					$email_message = "Su nueva contraseña ha sido generada, te recomendamos cambiarla inmediatamente al iniciar sesión: " .$new_password;
					$email_from = "support@illut.io";

					$headers = "From: ".$email_from."\r\n"."Reply-To: ".$email_from."\r\n"."X-Mailer: PHP/" . phpversion();
					@mail($_POST["email"], "GeoDisplay password", $email_message, $headers);
					exit();
				}
			}
		}
		echo "error";
	}

}
?>