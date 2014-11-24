<?php

require_once "database.php";

class tag extends database {

	private $db;
	private $nick;

	function __construct($nick) {
		$this->db = new database();
		$this->nick = $nick;
	}

	function get_num_user_tags(){
		$statement = "SELECT tags FROM Client WHERE nick = :nick";
		$query = $this->db->prepare($statement);
		$query->bindParam(':nick', 	$this->nick);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC)[0]["tags"];
	}

	function get_tags($limit_tags=9, $status = 1){
		$statement = "SELECT id, name, description, map, url, facebook, twitter FROM Tag WHERE client_nick = :nick and active = :status";
		$query = $this->db->prepare($statement);
		$query->bindParam(':nick', 	$this->nick);
		$query->bindParam(':status',$status, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	function get_full_data($id){
		$statement = "SELECT * FROM Tag WHERE client_nick = :nick AND id = :id";
		$query = $this->db->prepare($statement);
		$query->bindParam(':nick', 	$this->nick);
		$query->bindParam(':id', 	$id, PDO::PARAM_INT);
		$query->execute();
		if ($query->rowCount() == 0){ 
			return array();
		}
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
		
		$statement = "SELECT file_path, type FROM Multimedia WHERE id IN (SELECT multimedia_id FROM Multimedia_Tag WHERE tag_id = :tag_id)";
		$query = $this->db->prepare($statement);
		$query->bindParam(':tag_id', $id, PDO::PARAM_INT);
		$query->execute();
		$result_multimedia = $query->fetchAll(PDO::FETCH_ASSOC);

		$rows = array(
			"id" => 			$result[0]["id"],
			"name" => 			$result[0]["name"],
			"description" => 	$result[0]["description"],
			"url" => 			$result[0]["url"],
			"url_purchase" => 	$result[0]["url_purchase"],
			"latitude" => 		$result[0]["latitude"],
			"longitude"=> 		$result[0]["longitude"],
			"facebook"=>		$result[0]["facebook"],
			"twitter"=>			$result[0]["twitter"]
		);
		foreach ($result_multimedia as $row){
			$type = $row["type"];
			$rows[$type."_path"] = $row["file_path"];
		}
		return $rows;
	}

	function get_num_tags($status){
		$statement = "SELECT count(id) FROM Tag WHERE client_nick = :nick and active = :status";
		$query = $this->db->prepare($statement);
		$query->bindParam(':nick', 	$this->nick);
		$query->bindParam(':status',$status, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC)[0]["count(id)"];
	}

	function add_new_tag($num_tags, $space, $active = 1){
		if ( $num_tags <= 0){
			$_SESSION["error"]["num_tags"] = true;
			header("Location: ../index.php");
		}
		$statement = "INSERT INTO Tag (name, description, latitude, longitude, map, url, url_purchase, facebook, twitter, client_nick, created_at, updated_at, active) VALUES(:name, :description, :latitude, :longitude, :map, :url, :url_purchase, :facebook, :twitter, :client_nick, NOW(), NOW(), :active)";
		$query = $this->db->prepare($statement);
		$query->bindParam(':name', 			$_POST["name"]);
		$query->bindParam(':description', 	$_POST["description"]);
		$query->bindParam(':latitude', 		$_POST["latitude"]);
		$query->bindParam(':longitude', 	$_POST["longitude"]);
		$query->bindParam(':map', 			$map_path);
		$query->bindParam(':url', 			$_POST["url"]);
		$query->bindParam(':url_purchase', 	$_POST["purchase_url"]);
		$query->bindParam(':facebook', 		$_POST["facebook"]);
		$query->bindParam(':twitter', 		$_POST["twitter"]);
		$query->bindParam(':client_nick', 	$this->nick);
		$query->bindParam(':active', 		$active, PDO::PARAM_INT);
		$query->execute();
		$tag_id = $this->db->lastInsertId();

		require_once "multimedia.model.php";
		$multimedia = new multimedia($_SESSION["client"]["nick"]);

		$map_path = $multimedia->save_map($tag_id, $_POST["latitude"], $_POST["longitude"]);

		$statement = "UPDATE Tag SET map = :map WHERE id = :id AND client_nick = :client_nick";
		$query = $this->db->prepare($statement);
		$query->bindParam(':map', $map_path);
		$query->bindParam(':id', $tag_id, PDO::PARAM_INT);
		$query->bindParam(':client_nick', $this->nick);
		$query->execute();

		if ( isset($_POST["image-id"]) ){
			$multimedia->set_existing_file("image", $tag_id, $_POST["image-id"]);
		}
		else{
			$_SESSION["error"]["file_upload"] = true;
			header("Location: ../addtag.php");
		}
		if ( isset($_POST["video-id"]) ) {
			$multimedia->set_existing_file("video", $tag_id, $_POST["video-id"]);
		}
		if ( isset($_POST["audio-id"]) ) {
			$multimedia->set_existing_file("audio", $tag_id, $_POST["audio-id"]);
		}

		$_SESSION["client"]["tags"] = $this->get_num_user_tags();
	}

	function edit_media_file($type, $id){
		/*
		if( !(isset($_POST["video_id"]) && $_POST["video_id"] != "") ){
			if( !$_FILES["video"]["error"] == 0 ){
				header("Location: ../edit_tag.php?tag=".$_POST["id"]."&error=video");
			}
		}
		*/
		if( isset($_FILES[$type]) ){
			//If 0 edit file, if 4 delete file from server.
			$event = $_FILES[$type]["error"];
			if( $event == 0 ){
				if ( ($_FILES[$type]["size"]/(1024*1024)) > $_SESSION["client"]["space"] ){
					$_SESSION["error"]["user_space"] = true;
					header("Location: ../edit_tag.php?tag=".$id);
				}
				$path = "../media/".$this->nick;

				$base_path = $path."/".$type."/";
				while( file_exists( $base_path.$_FILES[$type]["name"] ) ){
					$base_path = $base_path."copy - ";
				}

				$path = $base_path.$_FILES[$type]["name"];
				if ( !move_uploaded_file($_FILES[$type]["tmp_name"], $path) ) {
					$_SESSION["error"]["file_upload"] = true;
					header("Location: ../edit_tag.php?tag=".$id);
				}
				$size = intval( $_FILES[$type]["size"] ) / (1024*1024);
				$_SESSION["client"]["space"] -= $size;

				$statement = "INSERT INTO Multimedia (name, type, size, file_path, client_nick, created_at, updated_at) VALUES (:name, :type, :size, :file_path, :client_nick, NOW(), NOW())";
				$query = $this->db->prepare($statement);
				$query->bindParam(':name', 		$_FILES[$type]["name"]);
				$query->bindParam(':type', 		$type);
				$query->bindParam(':size', 		$size, PDO::PARAM_INT);
				$query->bindParam(':file_path', $path);
				$query->bindParam(':client_nick',$this->nick);
				$query->execute();
				$multimedia_id = $this->db->lastInsertId();

				$statement = "DELETE FROM Multimedia_Tag WHERE tag_id = :tag_id AND type = :type";
				$query = $this->db->prepare($statement);
				$query->bindParam(':tag_id', 	$id, PDO::PARAM_INT);
				$query->bindParam(':type', 		$type);
				$query->execute();

				$statement = "INSERT INTO Multimedia_Tag VALUES (:multimedia_id, :tag_id, :type)";
				$query = $this->db->prepare($statement);
				$query->bindParam(':multimedia_id', $multimedia_id, PDO::PARAM_INT);
				$query->bindParam(':tag_id', $id, PDO::PARAM_INT);
				$query->bindParam(':type', 	 $type);
				$query->execute();
			}elseif( $event == 4 ){
				if( $type == "image" ){
					return;
				}
				$statement = "DELETE FROM Multimedia_Tag WHERE tag_id = :tag_id AND type = :type";
				$query = $this->db->prepare($statement);
				$query->bindParam(':tag_id', $id, PDO::PARAM_INT);
				$query->bindParam(':type', 	 $type);
				$query->execute();
			}else{
				$_SESSION["error"]["file_upload"] = true;
				header("Location: ../edit_tag.php?tag=".$id);
			}
		}elseif( isset($_POST[$type."_id"]) ) {
			if( $_POST[$type."_id"] != ""){
				$statement = "DELETE FROM Multimedia_Tag WHERE tag_id = :tag_id AND type = :type";
				$query = $this->db->prepare($statement);
				$query->bindParam(':tag_id', 	$id, PDO::PARAM_INT);
				$query->bindParam(':type', 		$type);
				$query->execute();

				$statement = "INSERT INTO Multimedia_Tag VALUES (:multimedia_id, :tag_id, :type)";
				$query = $this->db->prepare($statement);
				$query->bindParam(':multimedia_id', $_POST[$type."_id"], PDO::PARAM_INT);
				$query->bindParam(':tag_id', $id, PDO::PARAM_INT);
				$query->bindParam(':type', 	 $type);
				$query->execute();
			}
			else{
				if($type == "image"){
					return;
				}
				$statement = "DELETE FROM Multimedia_Tag WHERE tag_id = :tag_id AND type = :type";
				$query = $this->db->prepare($statement);
				$query->bindParam(':tag_id', 	$id, PDO::PARAM_INT);
				$query->bindParam(':type', 		$type);
				$query->execute();
			}
		}
	}

	function edit_tag($space){
		$statement = "SELECT map FROM Tag WHERE id = :id AND client_nick = :nick";
		$query = $this->db->prepare($statement);
		$query->bindParam(':id', 	$_POST["id"], PDO::PARAM_INT);
		$query->bindParam(':nick', 	$this->nick);
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC)[0];
		unlink("../".$result["map"]);

		require_once "multimedia.model.php";
		$multimedia = new multimedia($_SESSION["client"]["nick"]);

		$map_path = $multimedia->save_map($tag_id, $_POST["latitude"], $_POST["longitude"]);

		$statement = "UPDATE Tag SET name = :name, description = :description, latitude = :latitude, longitude = :longitude, map = :map, url = :url, url_purchase = :url_purchase, facebook = :facebook, twitter = :twitter WHERE id = :id AND client_nick = :nick";
		$query = $this->db->prepare($statement);
		$query->bindParam(":name", 			$_POST["name"]);
		$query->bindParam(":description", 	$_POST["description"]);
		$query->bindParam(":latitude", 		$_POST["latitude"]);
		$query->bindParam(":longitude", 	$_POST["longitude"]);
		$query->bindParam(":map", 			$map_path);
		$query->bindParam(":url", 			$_POST["url"]);
		$query->bindParam(":url_purchase", 	$_POST["purchase_url"]);
		$query->bindParam(":facebook", 		$_POST["facebook"]);
		$query->bindParam(":twitter", 		$_POST["twitter"]);
		$query->bindParam(":id", 			$_POST["id"], PDO::PARAM_INT);
		$query->bindParam(":nick", 			$this->nick);
		$query->execute();

		$this->edit_media_file("video", $_POST["id"]);
		$this->edit_media_file("audio", $_POST["id"]);
		$this->edit_media_file("image", $_POST["id"]);
		
	}

	function enable_tag($id){
		try{
			$statement = "SELECT active FROM Tag WHERE id = :id AND client_nick = :nick";
			$query = $this->db->prepare($statement);
			$query->bindParam(':id', 	$id, PDO::PARAM_INT);
			$query->bindParam(':nick', 	$this->nick);
			$query->execute();
			$stat = $query->fetchAll(PDO::FETCH_ASSOC);
			$stat = $stat[0]["active"];
			
			if ($stat == 0){
				$statement = "UPDATE Tag SET active = 1 WHERE id = :id AND client_nick = :nick";
				$query = $this->db->prepare($statement);
				$query->bindParam(':id', 	$id, PDO::PARAM_INT);
				$query->bindParam(':nick', 	$this->nick);
				$query->execute();
				
			}
			else if ($stat == 1){
				$statement = "UPDATE Tag SET active = 0 WHERE id = :id AND client_nick = :nick";
				$query = $this->db->prepare($statement);
				$query->bindParam(':id', 	$id, PDO::PARAM_INT);
				$query->bindParam(':nick', 	$this->nick);
				$query->execute();
			}
		}
		catch (Exception $e){
			echo json_encode(array(
				'error' => array(
					'msg' => $e->getMessage(),
					'code' => $e->getCode()
				)
			));
		}
	}

	function clone_tag($id){
		try{
			$statement = "SELECT latitude, longitude FROM Tag WHERE id = :id AND client_nick = :nick";

			$query = $this->db->prepare($statement);
			$query->bindParam(':id',$id, PDO::PARAM_INT);
			$query->bindParam(':nick',$this->nick);
			$query->execute();
			$position = $query->fetchAll(PDO::FETCH_ASSOC)[0];
			$latitude = $position["latitude"];
			$longitude = $position["longitude"];

			$statement = "INSERT INTO Tag (name, description, latitude, longitude, map, url, url_purchase, facebook, twitter, client_nick, active) SELECT name, description, latitude, longitude, map, url, url_purchase, facebook, twitter, client_nick, active FROM Tag WHERE id = :id AND client_nick = :nick";

			$query = $this->db->prepare($statement);
			$query->bindParam(':id',$id, PDO::PARAM_INT);
			$query->bindParam(':nick',$this->nick);
			$query->execute();

			$newId = $this->db->lastInsertId();
			require_once "multimedia.model.php";
			$multimedia = new multimedia($_SESSION["client"]["nick"]);

			$map_path = $multimedia->save_map($newId, $latitude, $longitude);

			$statement = "UPDATE Tag SET map = :map WHERE id = :id";
			$query = $this->db->prepare($statement);
			$query->bindParam(':map', $map_path);
			$query->bindParam(':id', $newId, PDO::PARAM_INT);
			$query->execute();

			$tryer = "SELECT multimedia_id, type FROM Multimedia_Tag WHERE tag_id = :id";
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
			$_SESSION["client"]["tags"] = $this->get_num_user_tags();
		}
		catch(Exception $e){
			echo json_encode(array(
				'error' => array(
					'msg' => $e->getMessage(),
					'code' => $e->getCode()
				)
			));
		}
	}

	function delete_tag($id){
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
			$query->bindParam(':nick', $this->nick);
			$query->execute();
			if ($query->rowCount() > 0){
				unlink("../".$map);
			}
			$_SESSION["client"]["tags"] = $this->get_num_user_tags();
		}
		catch(Exception $e){
			echo json_encode(array(
				'error' => array(
					'msg' => $e->getMessage(),
					'code' => $e->getCode()
				)
			));
		}	
	}
}
?>