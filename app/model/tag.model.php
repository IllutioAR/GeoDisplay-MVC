<?php

require_once "database.php";

class tag extends database {

	private $db;

	function __construct() {
		$this->db = new database();
	}

	function get_tags($nick, $limit_tags=9, $status = 1){
		$statement = "SELECT * FROM tag WHERE client_nick = :nick and active = :status";
		$query = $this->db->prepare($statement);
		$query->bindParam(':nick', $nick, PDO::PARAM_STR);
		$query->bindParam(':status', $status, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	function add_new_tag($nick, $active = 1){
		/*
			Pendientes:
			- Decrementar puntos al insertar.
			- Revisar que el usuario tenga espacio suficiente.
			- Decrementar el espacio del usuario al subir archivo.
			- Reflejar en la BD los archivos subidos, así como su relación con el tag.
		*/
		echo $_FILES["video"]["tmp_name"]."<br>";
		$statement = "INSERT INTO Tag (name, description, latitude, longitude, url, url_purchase, facebook, twitter, client_nick, active) VALUES(:name, :description, :latitude, :longitude, :url, :url_purchase, :facebook, :twitter, :client_nick, :active)";
		$query = $this->db->prepare($statement);
		$query->bindParam(':name', $_POST["name"], PDO::PARAM_STR);
		$query->bindParam(':description', $_POST["description"], PDO::PARAM_STR);
		$query->bindParam(':latitude', $_POST["latitude"], PDO::PARAM_STR);
		$query->bindParam(':longitude', $_POST["longitude"], PDO::PARAM_STR);
		$query->bindParam(':url', $_POST["url"], PDO::PARAM_STR);
		$query->bindParam(':url_purchase', $_POST["purchase_url"], PDO::PARAM_STR);
		$query->bindParam(':facebook', $_POST["facebook"], PDO::PARAM_STR);
		$query->bindParam(':twitter', $_POST["twitter"], PDO::PARAM_STR);
		$query->bindParam(':client_nick', $nick, PDO::PARAM_STR);
		$query->bindParam(':active', $active, PDO::PARAM_INT);
		$query->execute();

		function move_media_file($nick, $type){
			$path = "../media/".$nick;
			if( !file_exists($path) ){
				if( !mkdir($path) ){
					header("Location: ../addtag.php?error=fileUpload");
				}
				if( !mkdir($path."/video") ){
					header("Location: ../addtag.php?error=fileUpload");
				}
				if( !mkdir($path."/audio") ){
					header("Location: ../addtag.php?error=fileUpload");
				}
				if( !mkdir($path."/image") ){
					header("Location: ../addtag.php?error=fileUpload");
				}
			}
			$base_path = $path."/".$type."/";
			while( file_exists( $base_path.$_FILES[$type]["name"] ) ){
				$base_path = $base_path."copy - ";
			}
			$path = $base_path.$_FILES[$type]["name"];
			if ( move_uploaded_file($_FILES[$type]["tmp_name"], $path)) {
				
				echo "Query para insertar a BD";

			}
			else{
				header("Location: ../addtag.php?error=fileUpload");
			}
		}
		if( $_FILES["video"]["name"] != "" ){
			move_media_file($nick, "video");
		}else{
			header("Location: ../addtag.php?error=fileUpload");
		}
		if( $_FILES["audio"]["name"] != "" ){
			move_media_file($nick, "audio");
		}
		if( $_FILES["image"]["name"] != "" ){
			move_media_file($nick, "image");
		}
		
	}
}
?>