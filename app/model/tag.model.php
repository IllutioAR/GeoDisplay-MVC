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

	function move_media_file($nick, $type, $tag_id){
		if ($_FILES[$type]["size"] > $_SESSION["client"]["space"] ){
			header("Location: ../addtag.php?error=space");
		}
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
			$size = intval( $_FILES[$type]["size"] ) / (1024*1024);
			$_SESSION["client"]["space"] -= $size;
			$statement = "INSERT INTO Multimedia (name, type, size, file_path, client_nick) VALUES (:name, :type, :size, :file_path, :client_nick)";
			$query = $this->db->prepare($statement);
			$query->bindParam(':name', $_FILES[$type]["name"], PDO::PARAM_STR);
			$query->bindParam(':type', $type, PDO::PARAM_STR);
			$query->bindParam(':size', $size, PDO::PARAM_INT);
			$query->bindParam(':file_path', $path, PDO::PARAM_STR);
			$query->bindParam(':client_nick', $nick, PDO::PARAM_STR);
			$query->execute();
			$multimedia_id = $this->db->lastInsertId();
			$statement = "INSERT INTO Multimedia_tag VALUES (:multimedia_id, :tag_id, :type)";
			$query = $this->db->prepare($statement);
			$query->bindParam(':multimedia_id', $multimedia_id, PDO::PARAM_INT);
			$query->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
			$query->bindParam(':type', $type, PDO::PARAM_STR);
			$query->execute();
		}
		else{
			header("Location: ../addtag.php?error=fileUpload");
		}
	}

	function add_new_tag($nick, $num_tags, $space, $active = 1){
		/*
			Pendientes:
			- Decrementar puntos al insertar.
			- Revisar que el usuario tenga espacio suficiente.
			- Decrementar el espacio del usuario al subir archivo.
		*/
		echo $_FILES["video"]["tmp_name"]."<br>";
		if ( $num_tags <= 0){
			header("Location: ../addtag.php?error=numTags");
		}
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
		$tag_id = $this->db->lastInsertId();

		if( $_FILES["video"]["name"] != "" ){
			$this->move_media_file($nick, "video", $tag_id);
		}else{
			header("Location: ../addtag.php?error=fileUpload");
		}
		if( $_FILES["audio"]["name"] != "" ){
			$this->move_media_file($nick, "audio", $tag_id);
		}
		if( $_FILES["image"]["name"] != "" ){
			$this->move_media_file($nick, "image", $tag_id);
		}
		
	}
}
?>