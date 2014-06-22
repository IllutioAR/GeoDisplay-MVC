<?php
require '../app/controller/mvc.controller.php';

$mvc = new mvc_controller();
if ( isset( $_GET["type"] ) && $_GET["type"] == "video" ) {
	$mvc->multimedia("video");
}
elseif ( !isset( $_GET["type"]) ) {
	$mvc->multimedia("video");
}
elseif ( isset( $_GET["type"] ) && $_GET["type"] == "audio" ) {
	$mvc->multimedia("audio");
}
elseif ( isset( $_GET["type"] ) && $_GET["type"] == "image" ) {
	$mvc->multimedia("image");
}
else{
	$mvc->multimedia("video");
}
?>