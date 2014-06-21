<?php

require_once "database.php";

class client extends database {

	private $db;

	function __construct() {
		$this->db = new database();
	}

	function validate_client($email, $password){
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			$statement = "SELECT password FROM client WHERE email = :email";
			$query = $this->db->prepare($statement);
			$query->bindParam(':email', $email);
			$query->execute();
			if($query->rowCount() == 1){
				$hashed_password = $query->fetchAll(PDO::FETCH_ASSOC)[0]["password"];
				if(crypt($password, $hashed_password) == $hashed_password){
					return true;
				}
			}
		}
		return false;
	}

	function get_client_data($email){
		$statement = "SELECT * FROM Client WHERE email = :email ";
		$query = $this->db->prepare($statement);
		$query->bindParam(':email', $email);
		$query->execute();
		if($query->rowCount() == 1){
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		return "";
	}

	function get_num_files($nick){
		$path = "media/".$nick."/";
		$video = count(scandir($path."video/")) - 2;
		$audio = count(scandir($path."audio")) - 2;
		$image = count(scandir($path."image")) - 2;
		$total = $video + $audio + $image;
		return array("video" => $video, "audio" => $audio, "image" => $image, "total" => $total);
	}

	function get_files($nick, $type){
		$statement = "SELECT name, size, created_at FROM Multimedia WHERE client_nick = :nick AND type = :type";
		$query = $this->db->prepare($statement);
		$query->bindParam(":nick", $nick);
		$query->bindParam(":type", $type);
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	function get_num_files_dir($nick){
		$path = "media/".$nick."/";
		$video = count(scandir($path."video/")) - 2;
		$audio = count(scandir($path."audio")) - 2;
		$image = count(scandir($path."image")) - 2;
		$total = $video + $audio + $image;
		return array("video" => $video, "audio" => $audio, "image" => $image, "total" => $total);
	}

	function get_files_dir($nick, $type){
		$path = "media/".$nick."/".$type."/";
		$files = scandir($path);
		if(($key = array_search("..", $files)) !== false) {
			unset($files[$key]);
		}
		if(($key = array_search(".", $files)) !== false) {
			unset($files[$key]);
		}
		return $files;
	}

	function change_password($email, $password, $new_password, $new_password_confirm){
		$statement = "SELECT password FROM Client WHERE email = :email";
		$query = $this->db->prepare($statement);
		$query->bindParam(':email', $email);
		$query->execute();
		if($query->rowCount() == 1){
			if( $new_password === $new_password_confirm ){
				$hashed_password = $query->fetchAll(PDO::FETCH_ASSOC)[0]["password"];
				if(crypt($password, $hashed_password) == $hashed_password){
					if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH){
				        $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
				        $new_hashed_password = crypt($new_password, $salt);
				        $statement = "UPDATE Client SET password = :password WHERE email = :email";
						$query = $this->db->prepare($statement);
						$query->bindParam(':password', $new_hashed_password);
						$query->bindParam(':email', $email);
						$query->execute();
						return true;
				    }
				}
			}
		}
	}
}

?>