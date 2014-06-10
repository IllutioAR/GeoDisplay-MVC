<?php
	require("handlerDB.php");
	$db = new handlerDB("productDisplay");
	$email = "antonio.hdez93@gmail.com";
	$password = "123456";
	if(filter_var($email,FILTER_VALIDATE_EMAIL)){
		$statement = "SELECT * FROM user WHERE email = :email AND password = :password";
		$query = $db->prepare($statement);
		$query->bindParam(':email', $email, PDO::PARAM_STR);
		$query->bindParam(':password', $password, PDO::PARAM_STR);
		$query->execute();
		if($query->rowCount() === 1){
			echo "Sí";

		}
		header("Location: login.php?error=wrongPassword");
	}
	header("Location: login.php?error=invalidEmail");

?>
