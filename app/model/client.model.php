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
			$query->bindParam(':email', $email, PDO::PARAM_STR);
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
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->execute();
		if($query->rowCount() == 1){
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		return "";
	}

	function change_password($email, $password, $new_password, $new_password_confirm){
		$statement = "SELECT password FROM Client WHERE email = :email";
		$query = $this->db->prepare($statement);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
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
						$query->bindParam(':password', $new_hashed_password, PDO::PARAM_STR);
						$query->bindParam(':email', $email, PDO::PARAM_STR);
						$query->execute();
						return true;
				    }
				}
			}
		}
	}
}

?>