<?php
require '../app/controller/mvc.controller.php';

$mvc = new mvc_controller();
if( isset($_GET["tag"]) ){
	$mvc->edit_tag($_GET["tag"]);	
}

?>