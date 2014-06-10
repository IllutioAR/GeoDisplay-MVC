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
		$query->bindParam(':nick', $nick, PDO::PARAM_STR);
		$query->bindParam(':status', $status, PDO::PARAM_INT);
		//$query->bindParam(':limit_tags', $limit_tags, PDO::PARAM_INT);
		$query->execute();
		if($query->rowCount() > 0){
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		return "";
	}
}
?>