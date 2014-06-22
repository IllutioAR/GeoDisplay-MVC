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
		$query->bindParam(':nick', $nick);
		$query->bindParam(':status', $status, PDO::PARAM_INT);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	function create_media_directory($nick, $path = "../media/"){
		if($path == "../media/"){
			$path = "../media/".$nick;
		}
		if( !file_exists($path) ){
			if( !mkdir($path) ){
				header("Location: ../addtag.php?error=mediaDirectory");
			}
			if( !mkdir($path."/video") ){
				header("Location: ../addtag.php?error=mediaDirectory");
			}
			if( !mkdir($path."/audio") ){
				header("Location: ../addtag.php?error=mediaDirectory");
			}
			if( !mkdir($path."/image") ){
				header("Location: ../addtag.php?error=mediaDirectory");
			}
			if( !mkdir($path."/map") ){
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
			$statement = "INSERT INTO Multimedia_tag VALUES (:multimedia_id, :tag_id, :type)";
			$query = $this->db->prepare($statement);
			$query->bindParam(':multimedia_id', $multimedia_id);
			$query->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);
			$query->bindParam(':type', $type);
			$query->execute();
		}
		else{
			header("Location: ../addtag.php?error=fileUpload");
		}
	}

	function add_new_tag($nick, $num_tags, $space, $active = 1){
		echo $_FILES["video"]["tmp_name"]."<br>";
		if ( $num_tags <= 0){
			header("Location: ../addtag.php?error=numTags");
		}
		
		$url_map = "http://maps.googleapis.com/maps/api/staticmap?center=".$_POST["latitude"].",".$_POST["longitude"]."&zoom=17&size=400x150&markers=color:blue%7Clabel:S%7C11211%7C11206%7C11222&markers=color:red|".$_POST["latitude"].",".$_POST["longitude"]."&maptype=roadmap&sensor=false";
		$ch = curl_init ($url_map);
		curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
	    $data = curl_exec($ch);
	    curl_close($ch);
	    if( !file_exists("../media/".$nick) ){
			$this->create_media_directory($nick);
		}
		$map_path = "media/".$nick."/map/".$_POST["name"].".png";
		$fp = fopen("../".$map_path,"x");
		fwrite($fp, $data);
		fclose($fp);

		$statement = "INSERT INTO Tag (name, description, latitude, longitude, map, url, url_purchase, facebook, twitter, client_nick, active) VALUES(:name, :description, :latitude, :longitude, :map, :url, :url_purchase, :facebook, :twitter, :client_nick, :active)";
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