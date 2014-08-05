<?php

require_once "database.php";

class multimedia extends database {

	private $db;
	private $nick;

	function __construct($nick) {
		$this->db = new database();
		$this->nick = $nick;
	}

	function get_user_space(){
		$statement = "SELECT space FROM Client WHERE nick = :nick";
		$query = $this->db->prepare($statement);
		$query->bindParam(":nick", $this->nick);
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC)[0];
		return $result["space"];
	}

	function save_file($type){
		if ( ($_FILES["file"]["size"]/(1024*1024)) > $this->get_user_space() ){
			return "user_space";
		}
		if($type == "image"){
			$valid_exts = array("jpeg", "jpg", "png", "gif");
		}
		elseif ($type == "audio") {
			$valid_exts = array("mp3");
		}
		elseif ($type == "video") {
			$valid_exts = array("mp4", "3gp");
		}
		else{
			return "error";
		}
		$ext = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
		$max_size = 50 * 1024 * 1024; // 50 MB
		if( in_array($ext, $valid_exts) && $_FILES['file']['size'] < $max_size){
			$path = "../media/".$this->nick;
			$base_path = $path."/".$type."/";
			while( file_exists( $base_path.$_FILES["file"]["name"] ) ){
				$base_path = $base_path."(".uniqid().")";
			}
			$path = $base_path.$_FILES["file"]["name"];
			if ( move_uploaded_file($_FILES["file"]["tmp_name"], $path) ) {
				$size = intval( $_FILES["file"]["size"] ) / (1024*1024);
				$_SESSION["client"]["space"] = $this->get_user_space();

				$tmp_path = str_replace("../media/", "", $path);

				$statement = "INSERT INTO Multimedia (name, type, size, file_path, client_nick, created_at, updated_at) VALUES (:name, :type, :size, :file_path, :client_nick, NOW(), NOW())";
				$query = $this->db->prepare($statement);
				$query->bindParam(':name', $_FILES["file"]["name"]);
				$query->bindParam(':type', $type);
				$query->bindParam(':size', $size, PDO::PARAM_INT);
				$query->bindParam(':file_path', $tmp_path );
				$query->bindParam(':client_nick', $this->nick);
				$query->execute();
				return "success";
			}
			else{
				return "error_upload";
			}
		}
		else{
			return "file_extesion";
		}
	}

	function delete_file($id){
		echo "\nNick: ".$this->nick."\n";
		echo "Id: ".$id;

		$statement = "SELECT file_path, size FROM Multimedia WHERE id = :id AND client_nick = :nick AND id NOT IN (SELECT multimedia_id FROM Multimedia_Tag)";
		$query = $this->db->prepare($statement);
		$query->bindParam(":nick", $this->nick);
		$query->bindParam(":id", $id);
		$query->execute();
		if ( $query->rowCount() != 1 ){
			return;
		}

		$file = $query->fetchAll(PDO::FETCH_ASSOC)[0];
		echo $file["file_path"];
		echo $file["size"];
		if( unlink("../media/".$file["file_path"]) ){
			$_SESSION["client"]["space"] = $this->get_user_space();
			$statement = "DELETE FROM Multimedia WHERE id = :id AND client_nick = :nick";
			$query = $this->db->prepare($statement);
			$query->bindParam(":id", $id);
			$query->bindParam(":nick", $this->nick);
			$query->execute();
		}
	}

	function create_media_directory(){
		$path = "../media/".$this->nick;
		if(!file_exists($path)){
			mkdir($path);
			if(!file_exists($path."/video")){
				mkdir($path."/video");
			}
			if(!file_exists($path."/audio")){
				mkdir($path."/audio");
			}
			if(!file_exists($path."/image")){
				mkdir($path."/image");
			}
			if(!file_exists($path."/map")){
				mkdir($path."/map");
			}
		}
		header("Location: ../addtag.php?error=mediaDirectory");
	}

	function move_media_file($type, $tag_id){
		if ( ($_FILES[$type]["size"]/(1024*1024)) > $this->get_user_space() ){
			header("Location: ../addtag.php?error=space");
		}
		
		$path = "../media/".$this->nick;
		$this->create_media_directory($this->nick);

		$base_path = $path."/".$type."/";
		while( file_exists( $base_path.$_FILES[$type]["name"] ) ){
			$base_path = $base_path."(".$tag_id.")";
		}
		$path = $base_path.$_FILES[$type]["name"];
		if ( move_uploaded_file($_FILES[$type]["tmp_name"], $path)) {
			$size = intval( $_FILES[$type]["size"] ) / (1024*1024);
			$_SESSION["client"]["space"] = $this->get_user_space();

			$statement = "INSERT INTO Multimedia (name, type, size, file_path, client_nick, created_at, updated_at) VALUES (:name, :type, :size, :file_path, :client_nick, NOW(), NOW())";
			$query = $this->db->prepare($statement);
			$query->bindParam(':name', $_FILES[$type]["name"]);
			$query->bindParam(':type', $type);
			$query->bindParam(':size', $size, PDO::PARAM_INT);
			$query->bindParam(':file_path', str_replace("../media/", "", $path) );
			$query->bindParam(':client_nick', $this->nick);
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

	function set_existing_file($type, $tag_id, $multimedia_id){
		$statement = "INSERT INTO Multimedia_Tag VALUES (:multimedia_id, :tag_id, :type)";
		$query = $this->db->prepare($statement);
		$query->bindParam(':multimedia_id', $multimedia_id, PDO::PARAM_INT);
		$query->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
		$query->bindParam(':type', $type);
		$query->execute();
	}

	function save_map($tag_id, $latitude, $longitude){
		$url_map = "http://maps.googleapis.com/maps/api/staticmap?center=".$latitude.",".$longitude."&zoom=17&size=400x150&markers=color:blue%7Clabel:S%7C11211%7C11206%7C11222&markers=color:red|".$latitude.",".$longitude."&maptype=roadmap&sensor=false";
		$ch = curl_init ($url_map);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$data = curl_exec($ch);
		curl_close($ch);
		if( !file_exists("../media/".$this->nick) ){
			$this->create_media_directory();
		}
		$map_path = "media/".$this->nick."/map/".$tag_id."-".$latitude."-".$longitude.".png";
		$fp = fopen("../".$map_path,"x");
		fwrite($fp, $data);
		fclose($fp);
		return $map_path;
	}

	function get_num_files(){
		$path = "media/".$this->nick."/";
		$video = count(scandir($path."video/")) - 2;
		$audio = count(scandir($path."audio")) - 2;
		$image = count(scandir($path."image")) - 2;
		$total = $video + $audio + $image;
		return array("video" => $video, "audio" => $audio, "image" => $image, "total" => $total);
	}

	function get_files($type){
		$statement = "SELECT id, name, size, created_at FROM Multimedia WHERE client_nick = :nick AND type = :type AND id IN (SELECT multimedia_id FROM Multimedia_Tag)";
		$query = $this->db->prepare($statement);
		$query->bindParam(":nick", $this->nick);
		$query->bindParam(":type", $type);
		$query->execute();
		$files = $query->fetchAll(PDO::FETCH_ASSOC);
		$return = array();
		foreach ($files as $file) {
			list($fecha, $hora) = explode(" ", $file["created_at"]);
			$return[] = array(
					"name" => $file["name"],
					"size" => $file["size"],
					"created_at" => $fecha,
				);
		}
		$statement = "SELECT id, name, size, created_at FROM Multimedia WHERE client_nick = :nick AND type = :type AND id NOT IN (SELECT multimedia_id FROM Multimedia_Tag)";
		$query = $this->db->prepare($statement);
		$query->bindParam(":nick", $this->nick);
		$query->bindParam(":type", $type);
		$query->execute();
		$files = $query->fetchAll(PDO::FETCH_ASSOC);
		foreach ($files as $file) {
			list($fecha, $hora) = explode(" ", $file["created_at"]);
			$return[] = array(
					"id" => $file["id"],
					"name" => $file["name"],
					"size" => $file["size"],
					"created_at" => $fecha,
				);
		}
		sort($return);
		return $return;
	}

	function get_form_files($type){
		$statement = "SELECT id, name, size, created_at FROM Multimedia WHERE client_nick = :nick AND type = :type";
		$query = $this->db->prepare($statement);
		$query->bindParam(":nick", $this->nick);
		$query->bindParam(":type", $type);
		$query->execute();
		$files = $query->fetchAll(PDO::FETCH_ASSOC);
		foreach ($files as $file) {
			list($fecha, $hora) = explode(" ", $file["created_at"]);
			$return[] = array(
					"id" => $file["id"],
					"name" => $file["name"],
					"size" => number_format($file["size"], 2),
					"created_at" => $fecha,
				);
		}
		return $return;
	}

	function get_files_dir($type){
		$path = "media/".$this->nick."/".$type."/";
		$files = scandir($path);
		if(($key = array_search("..", $files)) !== false) {
			unset($files[$key]);
		}
		if(($key = array_search(".", $files)) !== false) {
			unset($files[$key]);
		}
		return $files;
	}

}
?>