<?php

require_once "database.php";

class client extends database {

	private $db;

	function __construct() {
		$this->db = new database();
	}

	function register($data){
		var_dump($data);
		$statement = "INSERT INTO Client (nick, email, password, name, logo, country, city, reseller_id, plan, tags, space, language, created_at, updated_at) VALUES (:nick, :email, :password, :name, :logo, :country, :city, 1, 'Starter', 10, 500, 'English', NOW(), NOW() )";
		$query = $this->db->prepare($statement);
		$query->bindParam(':nick', 		$data["nick"]);
		$query->bindParam(':email', 	$data["email"]);
		$query->bindParam(':password',	$data["password"]);
		$query->bindParam(':name', 		$data["name"]);
		$query->bindParam(':logo', 		$data["logo"]);
		$query->bindParam(':country', 	$data["country"]);
		$query->bindParam(':city', 		$data["city"]);
		$query->execute();
	}

	function user_exists($nick, $email){
		$statement = "SELECT id FROM Client WHERE nick = :nick OR email = :email";
		$query = $this->db->prepare($statement);
		$query->bindParam(':nick', $nick);
		$query->bindParam(':email', $email);
		$query->execute();
		if($query->rowCount() == 1){
			return true;
		}
		return false;
	}

	function validate_client($email, $password){
		$statement = "SELECT password FROM Client WHERE email = :email";
		$query = $this->db->prepare($statement);
		$query->bindParam(':email', $email);
		$query->execute();
		if($query->rowCount() == 1){
			$hashed_password = $query->fetchAll(PDO::FETCH_ASSOC)[0]["password"];
			if(crypt($password, $hashed_password) == $hashed_password){
				return true;
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

	function get_hashed_password($email){
		$statement = "SELECT password FROM Client WHERE email = :email";
		$query = $this->db->prepare($statement);
		$query->bindParam(':email', $email);
		$query->execute();
		if($query->rowCount() == 1){
			return $query->fetchAll(PDO::FETCH_ASSOC)[0]["password"];
		}
		return "";
	}

	function change_password($email, $new_hashed_password){
		$statement = "UPDATE Client SET password = :password WHERE email = :email";
		$query = $this->db->prepare($statement);
		$query->bindParam(':password', $new_hashed_password);
		$query->bindParam(':email', $email);
		$query->execute();
	}

	function password_recovery($email, $password){
        $statement = "UPDATE Client SET password = :new_password WHERE email = :email";
		$query = $this->db->prepare($statement);
		$query->bindParam(':email',$email);
		$query->bindParam(':new_password',$password);
		$query->execute();
	}
}

?>