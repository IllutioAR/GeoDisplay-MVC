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
				$hashedPassword = $query->fetchAll(PDO::FETCH_ASSOC)[0]["password"];
				if(crypt($password, $hashedPassword) == $hashedPassword){
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

	function change_password($nick, $password, $new_password, $new_password_confirm){
		$statement = "SELECT password FROM Client WHERE nick = :nick and password = :password ";
		$query = $this->db->prepare($statement);
		$query->bindParam(':nick', $nick, PDO::PARAM_STR);
		$query->bindParam(':password', $password, PDO::PARAM_STR);
		$query->execute();
		if($query->rowCount() == 1){
			if( $new_password === $new_password_confirm ){
				$statement = "UPDATE Client SET password = :password WHERE nick = :nick";
				$query = $this->db->prepare($statement);
				$query->bindParam(':password', $new_password, PDO::PARAM_STR);
				$query->bindParam(':nick', $nick, PDO::PARAM_STR);
				$query->execute();
			}
			else{
				header("Location: profile.php?error=password_confirm");
			}
		}else{
			header("Location: profile.php?error=wrong_password");
		}
	}
}

?>