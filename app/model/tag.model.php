<?php

require_once "database.php";

class tag extends database {

	private $db;

	function __construct() {
		$this->db = new database();
	}

	function get_tags($nick, $limit_tags=9, $status = 1){
		$statement = "SELECT * FROM Tag WHERE client_nick = :nick and active = :status";
		$query = $this->db->prepare($statement);
		$query->bindParam(':nick', $nick);
		$query->bindParam(':status', $status, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	function get_full_data($nick, $id){
		$statement = "SELECT id, name, description, url, url_purchase, latitude, longitude, client_nick, facebook, twitter FROM Tag WHERE client_nick = :nick AND id = :id";
		$query = $this->db->prepare($statement);
		$query->bindParam(':nick', $nick, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->execute();
		$num = $query->rowCount();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		
		if ($num == 0) return array();
		
		$statementVideo = "SELECT file_path, type FROM Multimedia WHERE id IN (SELECT multimedia_id FROM Multimedia_Tag WHERE tag_id = :tag_id)";
		$query = $this->db->prepare($statementVideo);
		$query->bindParam(':tag_id', $id, PDO::PARAM_INT);
		$query->execute();
		$result_multimedia = $query->fetchAll(PDO::FETCH_ASSOC);

		$rows = array(
			"id" => $result[0]["id"],
			"name" => utf8_encode($result[0]["name"]),
			"description" => utf8_encode($result[0]["description"]),
			"url" => $result[0]["url"],
			"url_purchase" => $result[0]["url_purchase"],
			"latitude" => $result[0]["latitude"],
			"longitude"=> $result[0]["longitude"],
			"facebook"=>$result[0]["facebook"],
			"twitter"=>$result[0]["twitter"]
		);
		foreach ($result_multimedia as $row){
			$type = $row["type"];
			$rows[$type."_path"] = $row["file_path"];
		}
		return $rows;
	}

	function get_num_tags($nick, $status){
		$statement = "SELECT count(*) FROM Tag WHERE client_nick = :nick and active = :status";
		$query = $this->db->prepare($statement);
		$query->bindParam(':nick', $nick);
		$query->bindParam(':status', $status, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC)[0]["count(*)"];
	}

	function create_media_directory($nick, $path = "../media/"){
		if($path == "../media/"){
			$path = "../media/".$nick;
		}
		if( !file_exists($path) ){
			if( !(mkdir($path) && mkdir($path."/video") && mkdir($path."/audio") && mkdir($path."/image") && mkdir($path."/map")) )
			{
				header("Location: ../addtag.php?error=mediaDirectory");
			}
		}
	}

	function move_media_file($nick, $type, $tag_id){
		if ( ($_FILES[$type]["size"]/(1024*1024)) > $_SESSION["client"]["space"] ){
			header("Location: ../addtag.php?error=space");
		}
		
		$path = "../media/".$nick;
		$this->create_media_directory($nick, $path);

		$base_path = $path."/".$type."/";
		while( file_exists( $base_path.$_FILES[$type]["name"] ) ){
			$base_path = $base_path."copy - ";
		}
		$path = $base_path.$_FILES[$type]["name"];
		if ( move_uploaded_file($_FILES[$type]["tmp_name"], $path)) {
			$size = intval( $_FILES[$type]["size"] ) / (1024*1024);
			$_SESSION["client"]["space"] -= $size;

			$statement = "INSERT INTO Multimedia (name, type, size, file_path, client_nick, created_at, updated_at) VALUES (:name, :type, :size, :file_path, :client_nick, NOW(), NOW())";
			$query = $this->db->prepare($statement);
			$query->bindParam(':name', $_FILES[$type]["name"]);
			$query->bindParam(':type', $type);
			$query->bindParam(':size', $size, PDO::PARAM_INT);
			$query->bindParam(':file_path', $path);
			$query->bindParam(':client_nick', $nick);
			$query->execute();
			$multimedia_id = $this->db->lastInsertId();

			$statement = "INSERT INTO Multimedia_Tag VALUES (:multimedia_id, :tag_id, :type)";
			$query = $this->db->prepare($statement);
			$query->bindParam(':multimedia_id', $multimedia_id, PDO::PARAM_INT);
			$query->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
			$query->bindParam(':type', $type);
			$query->execute();
		}
		else{
			header("Location: ../addtag.php?error=fileUpload");
		}
	}

	function save_map($nick, $tag_id, $latitude, $longitude){
		$url_map = "http://maps.googleapis.com/maps/api/staticmap?center=".$latitude.",".$longitude."&zoom=17&size=400x150&markers=color:blue%7Clabel:S%7C11211%7C11206%7C11222&markers=color:red|".$latitude.",".$longitude."&maptype=roadmap&sensor=false";
		$ch = curl_init ($url_map);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$data = curl_exec($ch);
		curl_close($ch);
		if( !file_exists("../media/".$nick) ){
			$this->create_media_directory($nick);
		}
		$map_path = "media/".$nick."/map/".$tag_id."-".$latitude."-".$longitude.".png";
		$fp = fopen("../".$map_path,"x");
		fwrite($fp, $data);
		fclose($fp);
		return $map_path;
	}

	function add_new_tag($nick, $num_tags, $space, $active = 1){
		if ( $num_tags <= 0){
			header("Location: ../addtag.php?error=numTags");
		}

		$statement = "INSERT INTO Tag (name, description, latitude, longitude, map, url, url_purchase, facebook, twitter, client_nick, created_at, updated_at, active) VALUES(:name, :description, :latitude, :longitude, :map, :url, :url_purchase, :facebook, :twitter, :client_nick, NOW(), NOW(), :active)";
		$query = $this->db->prepare($statement);
		$query->bindParam(':name', $_POST["name"]);
		$query->bindParam(':description', $_POST["description"]);
		$query->bindParam(':latitude', $_POST["latitude"]);
		$query->bindParam(':longitude', $_POST["longitude"]);
		$query->bindParam(':map', $map_path);
		$query->bindParam(':url', $_POST["url"]);
		$query->bindParam(':url_purchase', $_POST["purchase_url"]);
		$query->bindParam(':facebook', $_POST["facebook"]);
		$query->bindParam(':twitter', $_POST["twitter"]);
		$query->bindParam(':client_nick', $nick);
		$query->bindParam(':active', $active, PDO::PARAM_INT);
		$query->execute();
		$tag_id = $this->db->lastInsertId();

		$map_path = $this->save_map($nick, $tag_id, $_POST["latitude"], $_POST["longitude"]);

		$statement = "UPDATE Tag SET map = :map WHERE id = :id";
		$query = $this->db->prepare($statement);
		$query->bindParam(':map', $map_path);
		$query->bindParam(':id', $tag_id, PDO::PARAM_INT);
		$query->execute();

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
		header("Location: ../index.php");
	}

	function edit_media_file($nick, $type, $id){
		//If 0 edit file, if 4 delete file from server.
		$event = $_FILES[$type]["error"];
		if( $event == 0 ){
			if ( ($_FILES[$type]["size"]/(1024*1024)) > $_SESSION["client"]["space"] ){
				header("Location: ../edit_tag.php?tag=".$id."&error=space");
			}
			$path = "../media/".$nick;

			$base_path = $path."/".$type."/";
			while( file_exists( $base_path.$_FILES[$type]["name"] ) ){
				$base_path = $base_path."copy - ";
			}

			$path = $base_path.$_FILES[$type]["name"];
			if ( !move_uploaded_file($_FILES[$type]["tmp_name"], $path) ) {
				header("Location: ../edit_tag.php?tag=".$id."&error=fileUpload");
			}
			$size = intval( $_FILES[$type]["size"] ) / (1024*1024);
			$_SESSION["client"]["space"] -= $size;

			$statement = "INSERT INTO Multimedia (name, type, size, file_path, client_nick, created_at, updated_at) VALUES (:name, :type, :size, :file_path, :client_nick, NOW(), NOW())";
			$query = $this->db->prepare($statement);
			$query->bindParam(':name', $_FILES[$type]["name"]);
			$query->bindParam(':type', $type);
			$query->bindParam(':size', $size, PDO::PARAM_INT);
			$query->bindParam(':file_path', $path);
			$query->bindParam(':client_nick', $nick);
			$query->execute();
			$multimedia_id = $this->db->lastInsertId();

			$statement = "DELETE FROM Multimedia_Tag WHERE tag_id = :tag_id AND type = :type";
			$query = $this->db->prepare($statement);
			$query->bindParam(':tag_id', $id, PDO::PARAM_INT);
			$query->bindParam(':type', $type);
			$query->execute();

			$statement = "INSERT INTO Multimedia_Tag VALUES (:multimedia_id, :tag_id, :type)";
			$query = $this->db->prepare($statement);
			$query->bindParam(':multimedia_id', $multimedia_id, PDO::PARAM_INT);
			$query->bindParam(':tag_id', $id, PDO::PARAM_INT);
			$query->bindParam(':type', $type);
			$query->execute();
		}elseif( $event == 4 ){
			if( $type == "video" ){
				return;
			}
			$statement = "DELETE FROM Multimedia_Tag WHERE tag_id = :tag_id AND type = :type";
			$query = $this->db->prepare($statement);
			$query->bindParam(':tag_id', $id, PDO::PARAM_INT);
			$query->bindParam(':type', $type);
			$query->execute();
		}else{
			header("Location: ../edit_tag.php?tag=".$id."&error=fileUpload");
		}
	}

	function edit_tag($nick, $space){
		/*
		EDITAR:
		- Eliminar mapa anterior.
		- Guardar nuevo mapa.
		- MULTIMEDIA (CASOS):
			- El archivo no se modifica.
			- El archivo se modifica.
			- El archivo se elimina (sólo aplica para imágenes y audio).
		-
		*/
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		
		$statement = "UPDATE Tag SET name = :name, description = :description, latitude = :latitude, longitude = :longitude, url = :url, url_purchase = :url_purchase, facebook = :facebook, twitter = :twitter WHERE id = :id AND client_nick = :nick";
		$query = $this->db->prepare($statement);
		$query->bindParam(":name", $_POST["name"]);
		$query->bindParam(":description", $_POST["description"]);
		$query->bindParam(":latitude", $_POST["latitude"]);
		$query->bindParam(":longitude", $_POST["longitude"]);
		$query->bindParam(":url", $_POST["url"]);
		$query->bindParam(":url_purchase", $_POST["purchase_url"]);
		$query->bindParam(":facebook", $_POST["facebook"]);
		$query->bindParam(":twitter", $_POST["twitter"]);
		$query->bindParam(":id", $_POST["id"], PDO::PARAM_INT);
		$query->bindParam(":nick", $nick);
		$query->execute();
		var_dump($query->errorInfo());

		if( isset($_FILES["video"]["name"]) ){
			if( $_FILES["video"]["error"] == 0 ){
				$this->edit_media_file($nick, "video", $_POST["id"]);
			}
			else{
				header("Location: ../edit_tag.php?tag=".$_POST["id"]."&error=video");
			}
		}
		if( isset($_FILES["audio"]["name"]) ){
			$this->edit_media_file($nick, "audio", $_POST["id"]);
		}
		if( isset($_FILES["image"]["name"]) ){
			$this->edit_media_file($nick, "image", $_POST["id"]);
		}
		
	}

	function enable_tag($nick, $id){
		try{
			$statement = "SELECT active FROM Tag WHERE id = :id AND client_nick = :nick";
			$query = $this->db->prepare($statement);
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query->bindParam(':nick', $nick);
			$query->execute();
			$stat = $query->fetchAll(PDO::FETCH_ASSOC);
			$stat = $stat[0]["active"];
			
			if ($stat == 0){
				$statement = "UPDATE Tag SET active = 1 WHERE id = :id AND client_nick = :nick";
				$query = $this->db->prepare($statement);
				$query->bindParam(':id', $id, PDO::PARAM_INT);
				$query->bindParam(':nick', $_SESSION["client"]["nick"]);
				$query->execute();
				
			}
			else if ($stat == 1){
				$statement = "UPDATE Tag SET active = 0 WHERE id = :id AND client_nick = :nick";
				$query = $this->db->prepare($statement);
				$query->bindParam(':id', $id, PDO::PARAM_INT);
				$query->bindParam(':nick', $_SESSION["client"]["nick"]);
				$query->execute();
			}
			else {
				throw new Exception("No se logró habilitar, datos inválidos", 1);		
			}	
		}
		catch (Exception $e){
			echo json_encode(array(
				'error' => array(
					'msg' => $e->getMessage(),
					'code' => $e->getCode(),
				),
			));
		}
	}

	function clone_tag($nick, $id){
		try{
			$statement = "SELECT latitude, longitude FROM Tag WHERE id = :id AND client_nick = :nick";

			$query = $this->db->prepare($statement);
			$query->bindParam(':id',$id, PDO::PARAM_INT);
			$query->bindParam(':nick',$nick);
			$query->execute();
			$position = $query->fetchAll(PDO::FETCH_ASSOC)[0];
			$latitude = $position["latitude"];
			$longitude = $position["longitude"];

			$statement = "INSERT INTO Tag (name, description, latitude, longitude, map, url, url_purchase, facebook, twitter, client_nick, active) SELECT name, description, latitude, longitude, map, url, url_purchase, facebook, twitter, client_nick, active FROM Tag WHERE id = :id AND client_nick = :nick";

			$query = $this->db->prepare($statement);
			$query->bindParam(':id',$id, PDO::PARAM_INT);
			$query->bindParam(':nick',$nick);
			$query->execute();

			$newId = $this->db->lastInsertId();

			$map_path = $this->save_map($nick, $newId, $latitude, $longitude);

			$statement = "UPDATE Tag SET map = :map WHERE id = :id";
			$query = $this->db->prepare($statement);
			$query->bindParam(':map', $map_path);
			$query->bindParam(':id', $newId, PDO::PARAM_INT);
			$query->execute();

			$tryer = "SELECT multimedia_id, type FROM Multimedia_tag WHERE tag_id = :id";
			$query = $this->db->prepare($tryer);
			$query->bindParam(':id',$id, PDO::PARAM_INT);
			$query->execute();
			$tag_data = ($query->fetchAll(PDO::FETCH_ASSOC));
			foreach ($tag_data as $tag){
				$statement = "INSERT INTO Multimedia_Tag (multimedia_id, tag_id, type) VALUES (:multimedia_id, :tag_id, :type)";
				$query = $this->db->prepare($statement);
				$query->bindParam(':multimedia_id', $tag["multimedia_id"], PDO::PARAM_INT);
				$query->bindParam(':tag_id',$newId, PDO::PARAM_INT);
				$query->bindParam(':type',$tag["type"]);
				$query->execute();
			}
			exit();
		}
		catch(Exception $e){
			echo json_encode(array(
				'error' => array(
					'msg' => $e->getMessage(),
					'code' => $e->getCode(),
				),
			));
		}
	}

	function delete_tag($nick, $id){
		try {
			$statement = "SELECT map FROM Tag WHERE id = :id";
			$query = $this->db->prepare($statement); 
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query -> execute();
			$map = $query->fetchAll(PDO::FETCH_ASSOC)[0]["map"];
			
			$statement = "DELETE FROM Multimedia_Tag WHERE tag_id = :id";
			$query = $this->db->prepare($statement); 
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query -> execute();

			$statement = "DELETE FROM Tag WHERE id = :id AND client_nick = :nick";
			$query = $this->db->prepare($statement);
			$query->bindParam(':id', $id, PDO::PARAM_INT);
			$query->bindParam(':nick', $nick);
			$query->execute();
			if ($query->rowCount() > 0){
				unlink("../".$map);
			}
		}
		catch(Exception $e){
			echo json_encode(array(
				'error' => array(
					'msg' => $e->getMessage(),
					'code' => $e->getCode(),
				),
			));
		}	
	}
}
?>