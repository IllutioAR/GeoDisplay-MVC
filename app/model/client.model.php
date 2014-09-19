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
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
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

	function password_recovery($email){
		$email_to = $email;
		$characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $newPassword = "";
	    for ($i = 0; $i < 8; $i++) {
	        $newPassword .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    $newPass = $newPassword;
		if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH){
	        $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
	        $newPass = crypt($newPass, $salt);
	        $statement = "UPDATE Client SET password = :newPass WHERE email = :email";
			$query = $this->db->prepare($statement);
			$query->bindParam(':email',$email);
			$query->bindParam(':newPass',$newPass);
			$query->execute();

			$email_message = "Su nueva contraseña ha sido generada, te recomendamos cambiarle inmediatamente al iniciar sesión: " .$newPassword;
			$email_from = 'support@illut.io';

			$headers = 'From: '.$email_from."\r\n".
			'Reply-To: '.$email_from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			@mail ($email, "", $email_message, $headers);
	    }
	}
}

?>