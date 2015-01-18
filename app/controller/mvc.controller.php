<?php

require '../app/model/tag.model.php';
require '../app/model/client.model.php';
require '../app/model/multimedia.model.php';

class mvc_controller {

	// Método que valida la sesión del usuario, si la sesión no es válida redirige automáticamente al login.
	function validate_session(){
		session_start();
		if( isset($_SESSION["client"]) ){
			return true;
		}
		header("Location: login.php");
	}

	function register(){
		session_start();
		if( isset($_SESSION["logged"]) && $_SESSION["logged"] ){
			header("Location: index.php");	
			exit();
		}
		if(
			isset( $_POST["nick"] ) &&
			isset( $_POST["email"] ) &&
			isset( $_POST["password"] ) &&
			isset( $_POST["password2"] ) &&
			isset( $_POST["name"] ) &&
			isset( $_POST["country"] ) &&
			isset( $_POST["city"] )
		){
			if( preg_match("/^[a-z]\w{0,19}$/i", $_POST["nick"]) != 1 ){
				$_SESSION["error"]["nick"] = true;
				header("Location: register.php");
				exit();
			}
			elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
				$_SESSION["error"]["email"] = true;
				header("Location: register.php");
				exit();
			}
			elseif ( strlen($_POST["password"]) < 6 || $_POST["password"] != $_POST["password2"]) {
				$_SESSION["error"]["password"] = true;
				header("Location: register.php");
				exit();
			}

			$user = new client();
			if( $user->user_exists($_POST["nick"], $_POST["email"] ) ){
				$_SESSION["error"]["user_exists"] = true;
				header("Location: register.php");
				exit();
			}

			$data["nick"] = $_POST["nick"];
			$data["email"] = $_POST["email"];
			if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH){
		        $salt = "$2y$11$" . substr(md5(uniqid(rand(), true)), 0, 22);
		        $data["password"] = crypt($_POST["password"], $salt);
		    }
			$data["name"] = $_POST["name"];
			$data["logo"] = "media/default/profile/default.png";
			$data["country"] = $_POST["country"];
			$data["city"] = $_POST["city"];
			

			$path = "media/".$_POST["nick"];
			mkdir($path);
			mkdir($path."/video");
			mkdir($path."/audio");
			mkdir($path."/map");
			mkdir($path."/image");
			if( move_uploaded_file($_FILES["logo"]["tmp_name"], "media/".$_POST["nick"]."/image/".$_FILES["logo"]["name"]) ){
				//$data["logo"] = "media/".$_POST["nick"]."/image/".$_FILES["logo"]["name"];
			}
			mkdir($path."/thumbnail");
			if( move_uploaded_file($_FILES["logo"]["tmp_name"], "media/".$_POST["nick"]."/thumbnail/".$_FILES["logo"]["name"]) ){
				$data["logo"] = "media/".$_POST["nick"]."/thumbnail/".$_FILES["logo"]["name"];
			}	
			$user->register($data);
			
			header("Location: login.php");

		}else{
			$pagina = $this->load_page('../app/views/default/modules/register.php');
			$this->view_page($pagina);	
		}
		
	}

	// Muestra la vista de login, es el único método que valida la session por sí mismo sin utilizar el método validate_session()
	function login(){
		session_start();
		if( isset($_POST["email"]) && isset($_POST["password"]) ){
			$user = new client();
			if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
				$_SESSION["logged"] = $user->validate_client( $_POST["email"], $_POST["password"] );
				if($_SESSION["logged"]) {
					$_SESSION["client"] = $user->get_client_data( $_POST["email"] )[0];
					$path = "media/".$_SESSION["client"]["nick"];
					if(!file_exists($path)){
						mkdir($path);
						if(!file_exists($path."/video")){
							mkdir($path."/video");
						}
						if(!file_exists($path."/audio")){
							mkdir($path."/audio");
						}
						if(!file_exists($path."/image")){
							mkdir($path."/image");
						}
						if(!file_exists($path."/thumbnail")){
							mkdir($path."/thumbnail");
						}
						if(!file_exists($path."/map")){
							mkdir($path."/map");
						}
					}
					header("Location: index.php");
				}else{
					$_SESSION["error"]["login"] = true;
					header("Location: login.php");
				}
			}else{
				header("Location: login.php");	
			}
		}else if( isset($_SESSION["logged"]) && $_SESSION["logged"] ){
			header("Location: index.php");
		}else{
			$pagina = $this->load_page('../app/views/default/modules/login.php');
			$this->view_page($pagina);
		}
	}

	function show_tags($active = 1)
	{
		$this->validate_session();
		$css = array("index.css");
		$js = array(
				"js/tags.js", 
				"js/search.js"
			);
		$pagina = $this->load_template("Index", "es", $css, $js );
		$menu = $this->load_page('../app/views/default/modules/tags/menu.php');
		$pagina = $this->replace_content('/\#{MENU}\#/ms' ,$menu , $pagina);

		if ( $active == 1 ){
			$pagina = $this->replace_content('/\#{ACTIVE}\#/ms' ,"class='active'" , $pagina);
			$pagina = $this->replace_content('/\#{INACTIVE}\#/ms' ,"" , $pagina);
		}
		else{
			$pagina = $this->replace_content('/\#{ACTIVE}\#/ms' ,"" , $pagina);
			$pagina = $this->replace_content('/\#{INACTIVE}\#/ms' ,"class='active'" , $pagina);
		}

		ob_start();
		$tag = new tag($_SESSION["client"]["nick"]);
		$data = array();
		if( $active == 1 ){
			$data = $tag->get_tags(); // get_tags(9, 1); 9 es el número de tags a mostrar, el 1 son los activos
		}
		elseif ( $active == 0 ){
			$data = $tag->get_tags(9, 0); // 9 es el número de tags a mostrar, el 0 son los inactivos
		}
		$active_tags = $tag->get_num_tags(1);
		$inactive_tags = $tag->get_num_tags(0);
		$pagina = $this->replace_content('/\#{NUMACTIVE}\#/ms', $active_tags , $pagina);
		$pagina = $this->replace_content('/\#{NUMINACTIVE}\#/ms', $inactive_tags , $pagina);
		include "../app/views/default/modules/tags/tags.php";
		$table = ob_get_clean();
		$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms', $table , $pagina);		
		
		if ($active == 1) {
			$pagina = $this->replace_content('/\#{DISABLE}\#/ms' ,"#{INDEX.DISABLE}#" , $pagina);
		}
		else{
			$pagina = $this->replace_content('/\#{DISABLE}\#/ms' ,"#{INDEX.ENABLE}#" , $pagina);
		}

		$pagina = $this->show_notification($pagina);

		$pagina = $this->set_language($pagina,"index");

		$this->view_page($pagina);
	}

	function profile(){
		$this->validate_session();
		$css = array("profile.css");
		$js = array("js/profile.js");
		$pagina = $this->load_template("Profile", "es", $css, $js );
		$contenido = $this->load_page('../app/views/default/modules/profile/profile.php');
		$pagina = $this->replace_content('/\#{MENU}\#/ms' , "", $pagina);
		$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms' ,$contenido , $pagina);
		$pagina = $this->replace_content('/\#{LOGO}\#/ms' ,$_SESSION["client"]["logo"] , $pagina);
		$pagina = $this->replace_content('/\#{NAME}\#/ms' ,$_SESSION["client"]["name"] , $pagina);
		$pagina = $this->replace_content('/\#{CITY}\#/ms' ,$_SESSION["client"]["city"] , $pagina);
		$pagina = $this->replace_content('/\#{COUNTRY}\#/ms' ,$_SESSION["client"]["country"] , $pagina);
		$pagina = $this->replace_content('/\#{NICK}\#/ms' , $_SESSION["client"]["nick"] , $pagina);
		$pagina = $this->replace_content('/\#{EMAIL}\#/ms' ,$_SESSION["client"]["email"] , $pagina);
		$pagina = $this->replace_content('/\#{PLAN}\#/ms' ,$_SESSION["client"]["plan"] , $pagina);

		$plan_info = $this->get_plan_info($_SESSION["client"]["plan"]);

		$used_tags = $plan_info["total_tags"] - $_SESSION["client"]["tags"];
		$percentage_tags = $used_tags / $plan_info["total_tags"] * 100;

		$used_space = number_format($plan_info["total_space"] - $_SESSION["client"]["space"], 2);
		$percentage_space = round($used_space / $plan_info["total_space"] * 100);
		
		$pagina = $this->replace_content('/\#{USEDTAGS}\#/ms' ,$used_tags , $pagina);
		$pagina = $this->replace_content('/\#{TOTALTAGS}\#/ms' ,$plan_info["total_tags"] , $pagina);
		$pagina = $this->replace_content('/\#{PERCENTAGETAGS}\#/ms' ,$percentage_tags , $pagina);

		$pagina = $this->replace_content('/\#{USEDSPACE}\#/ms' , $used_space , $pagina);
		$pagina = $this->replace_content('/\#{TOTALSPACE}\#/ms' ,$plan_info["total_space"] , $pagina);
		$pagina = $this->replace_content('/\#{PERCENTAGESPACE}\#/ms' ,$percentage_space , $pagina);
		
		$pagina = $this->show_notification($pagina);

		$pagina = $this->set_language($pagina,"profile");

		$this->view_page($pagina);
	}

	function add_tag(){
		$this->validate_session();
		$css = array("addtag.css");
		$js = array(
					"js/addtag.js/navigator.js",
					"js/addtag.js/file-selector-pc.js",
					"js/addtag.js/file-selector-cloud.js",
					"https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places",
					//"http://maps.googleapis.com/maps/api/js?key=AIzaSyBnIOf-8Tp4UdM1TnwOi8Dx-X0V7cop-9A&sensor=false",
					"js/map.js"
				);
		$pagina = $this->load_template("Add tag", "es", $css, $js );
		$menu = $this->load_page('../app/views/default/modules/addtag/menu.php');
		$pagina = $this->replace_content('/\#{MENU}\#/ms' ,$menu , $pagina);
		$form = $this->load_page('../app/views/default/modules/addtag/form.php');
		$modal = $this->load_page('../app/views/default/modules/addtag/modal.php');
		$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms', $form.$modal , $pagina);
		
		$pagina = $this->show_notification($pagina);

		$pagina = $this->set_language($pagina,"addtag");

		$this->view_page($pagina);
	}

	function edit_tag($id){
		$this->validate_session();
		$css = array("edittag.css");
		$js = array(
					"https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false",
					"js/map_edit.js",
					"js/edittag.js"
				);
		$pagina = $this->load_template("Edit tag", "es", $css, $js );
		$menu = $this->load_page('../app/views/default/modules/edittag/menu.php');
		$pagina = $this->replace_content('/\#{MENU}\#/ms' ,$menu , $pagina);

		ob_start();

		$tag = new tag($_SESSION["client"]["nick"]);
		
		$tag = $tag->get_full_data($id);
		
		if($tag == array()){
			$_SESSION["error"]["edit_tag"] = true;
			header("Location: index.php");
		}
		include "../app/views/default/modules/edittag/form.php";
		$form = ob_get_clean();
		$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms', $form , $pagina);

		$pagina = $this->show_notification($pagina);

		$pagina = $this->set_language($pagina,"edittag");

		$this->view_page($pagina);
	}

	function show_gif(){
		$this->validate_session();

		/*TEMPLATE STUFF*/
		$css = array("gif.css");
		$js = array(
				"js/gif.js", 
				"js/search.js"
			);

		$pagina = $this->load_template("Gifs", "es", $css, $js );
		$menu = $this->load_page('../app/views/default/modules/gif/menu.php');
		$pagina = $this->replace_content('/\#{MENU}\#/ms' ,$menu , $pagina);

		$tag = new tag($_SESSION["client"]["nick"]);

		$data = $tag->get_gif();
		$num_gifs = $tag->get_num_gif();
		
		$pagina = $this->replace_content('/\#{NUMACTIVE}\#/ms', $num_gifs, $pagina);
		
		ob_start();
		include "../app/views/default/modules/gif/gifs.php";
		$gif = ob_get_clean();

		$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms', $gif, $pagina);

		/*FINAL STUFF*/
		$pagina = $this->show_notification($pagina);
		$pagina = $this->set_language($pagina, "gif");
		$this->view_page($pagina);
	}

	function add_gif(){
		$this->validate_session();
		$css = array("addgif.css");
		$js = array(
			"https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places",
			"js/map.js",
			"js/addgif.js/navigator.js",
			"js/addgif.js/fileSelect.js",
			"js/addgif.js/imagePreview.js",
			);
		$pagina = $this->load_template("Agregar gif", "es", $css, $js );
		$menu = $this->load_page("../app/views/default/modules/addgif/menu.php");
		$pagina = $this->replace_content('/\#{MENU}\#/ms' ,$menu , $pagina);

		$form = $this->load_page("../app/views/default/modules/addgif/form.php");
		$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms' ,$form , $pagina);
		
		$pagina = $this->show_notification($pagina);
		$pagina = $this->set_language($pagina, "addgif");
		$this->view_page($pagina);
	}

	function multimedia($type){
		$this->validate_session();
		$css = array("media.css");
		$js = array(
			"js/multimedia.js",
			"js/jquery.form.js"
			);
		$pagina = $this->load_template("Multimedia", "es", $css, $js );
		$menu = $this->load_page("../app/views/default/modules/multimedia/menu.php");
		$pagina = $this->replace_content('/\#{MENU}\#/ms' ,$menu , $pagina);
		
		if ( $type == "video" ){
			$pagina = $this->replace_content('/\#{MENUVIDEO}\#/ms' ,"class='active'" , $pagina);
		}
		elseif ( $type == "audio" ){
			$pagina = $this->replace_content('/\#{MENUAUDIO}\#/ms' ,"class='active'" , $pagina);
		}
		elseif ( $type == "image" ){
			$pagina = $this->replace_content('/\#{MENUIMAGE}\#/ms' ,"class='active'" , $pagina);
		}
		$pagina = $this->replace_content('/\#{MENUVIDEO}\#/ms' ,"" , $pagina);
		$pagina = $this->replace_content('/\#{MENUAUDIO}\#/ms' ,"" , $pagina);
		$pagina = $this->replace_content('/\#{MENUIMAGE}\#/ms' ,"" , $pagina);

		$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms' ,"<div><div class=\"row\">#{SIDEBAR}##{CONTENIDO}#</div></div>" , $pagina);

		$overview = $this->load_page("../app/views/default/modules/multimedia/overview.php");
		$pagina = $this->replace_content('/\#{SIDEBAR}\#/ms' ,$overview , $pagina);

		$plan_info = $this->get_plan_info($_SESSION["client"]["plan"]);
		$used_space = number_format($plan_info["total_space"] - $_SESSION["client"]["space"], 2);
		$percentage_space = round($used_space / $plan_info["total_space"] * 100);

		$pagina = $this->replace_content('/\#{USEDSPACE}\#/ms' ,$used_space , $pagina);
		$pagina = $this->replace_content('/\#{TOTALSPACE}\#/ms' ,$plan_info["total_space"] , $pagina);
		$pagina = $this->replace_content('/\#{PERCENTAGESPACE}\#/ms' ,$percentage_space , $pagina);

		$multimedia = new multimedia($_SESSION["client"]["nick"]);
		$num_files = $multimedia->get_num_files();
		
		$pagina = $this->replace_content('/\#{VIDEO}\#/ms' ,$num_files["video"] , $pagina);
		$pagina = $this->replace_content('/\#{AUDIO}\#/ms' ,$num_files["audio"] , $pagina);
		$pagina = $this->replace_content('/\#{IMAGE}\#/ms' ,$num_files["image"] , $pagina);
		$pagina = $this->replace_content('/\#{TOTAL}\#/ms' ,$num_files["total"] , $pagina);		
		ob_start();
		$files = $multimedia->get_files($type);
		include "../app/views/default/modules/multimedia/files.php";
		$table = ob_get_clean();
		$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms', $table , $pagina);
		
		$pagina = $this->show_notification($pagina);

		$pagina = $this->set_language($pagina, "multimedia");

		$this->view_page($pagina);
	}

	private function load_template($title, $lang, $css, $js){
		$pagina = $this->load_page('../app/views/default/page.php');
		$header = $this->load_page('../app/views/default/sections/header.php');
		$footer = $this->load_page('../app/views/default/sections/footer.php');
		$pagina = $this->replace_content('/\#{LANG}\#/ms' ,$lang , $pagina);
		$pagina = $this->replace_content('/\#{TITLE}\#/ms',$title , $pagina);
		$css_string = $js_string = "";
		foreach ($css as $file) {
			$css_string .= "<link href='css/".$file."' rel='stylesheet'>";
		}
		$pagina = $this->replace_content('/\#{CSS}\#/ms' ,$css_string , $pagina);
		foreach ($js as $file) {
			$js_string .= "<script src='".$file."'></script>";
		}
		$pagina = $this->replace_content('/\#{JS}\#/ms' ,$js_string , $pagina);
		$pagina = $this->replace_content('/\#{HEADER}\#/ms' ,$header , $pagina);
		$pagina = $this->replace_content('/\#{USER}\#/ms' , $_SESSION["client"]["nick"], $pagina);
		$pagina = $this->replace_content('/\#{FOOTER}\#/ms' ,$footer , $pagina);
		return $pagina;
	}

	private function load_page($page){
		return file_get_contents($page);
	}

	private function view_page($html){
		echo $html;
	}

	private function replace_content($in='/\#{CONTENIDO}\#/ms', $out, $pagina){
		return preg_replace($in, $out, $pagina);
	}

	function show_notification($pagina){
		$language = json_decode(file_get_contents('../app/language/language.json'), true);
		$lan = $_SESSION["client"]["language"];

		$notification = "";
		if (isset( $_SESSION["success"] )) {
			$notification = $this->load_page('../app/views/default/modules/notification/success.php');
			foreach ($_SESSION["success"] as $key => $value) {
				$new_key = "SUCCESS-".strtoupper($key);
				$notification = $this->replace_content('/\#{MESSAGE}\#/ms', "#{NOTIFICATION.".$new_key."}#", $notification);
				$notification = $this->replace_content("/\#{NOTIFICATION.$new_key}\#/ms", $language[$lan]["notifications"][$new_key], $notification);
			}
			unset( $_SESSION["success"] );
		}
		elseif (isset( $_SESSION["error"] )) {
			$notification = $this->load_page('../app/views/default/modules/notification/error.php');
			foreach ($_SESSION["error"] as $key => $value) {
				$new_key = "ERROR-".strtoupper($key);
				$notification = $this->replace_content('/\#{MESSAGE}\#/ms', "#{NOTIFICATION.".$new_key."}#", $notification);
				$notification = $this->replace_content("/\#{NOTIFICATION.$new_key}\#/ms", $language[$lan]["notifications"][$new_key], $notification);
			}
			unset( $_SESSION["error"] );
		}
		elseif (isset( $_SESSION["info"] )) {
			$notification = $this->load_page('../app/views/default/modules/notification/info.php');
			foreach ($_SESSION["info"] as $key => $value) {
				$new_key = "INFO-".strtoupper($key);
				$notification = $this->replace_content('/\#{MESSAGE}\#/ms', "#{NOTIFICATION.".$new_key."}#", $notification);
				$notification = $this->replace_content("/\#{NOTIFICATION.$new_key}\#/ms", $language[$lan]["notifications"][$new_key], $notification);
			}
			unset( $_SESSION["info"] );
		}
		return $this->replace_content('/\#{NOTIFICATION}\#/ms', $notification, $pagina);
	}

	private function set_language($pagina, $section){
		$language = json_decode(file_get_contents('../app/language/language.json'), true);
		$lan = $_SESSION["client"]["language"];
		foreach ($language[$lan]["general"] as $key => $value) {
			$pagina = $this->replace_content('/\#{GENERAL.'.$key.'}\#/ms', $language[$lan]["general"][$key], $pagina);
		}

		foreach ($language[$lan][$section] as $key => $value) {
			$pagina = $this->replace_content('/\#{'.strtoupper($section).'.'.$key.'}\#/ms', $language[$lan][$section][$key], $pagina);
		}
		return $pagina;
	}

	private function get_plan_info($plan){
		if($plan == "Starter"){
			$info = array(
				"total_tags" => 10,
				"total_space" => 500
				);
		}
		elseif($plan == "Basic"){
			$info = array(
				"total_tags" => 50,
				"total_space" => 500
				);
		}
		elseif($plan == "Medium"){
			$info = array(
				"total_tags" => 100,
				"total_space" => 500
				);
		}
		elseif($plan == "Advanced"){
			$info = array(
				"total_tags" => 200,
				"total_space" => 500
				);
		}
		else{
			$info = array(
				"total_tags" => 0,
				"total_space" => 0
				);
		}
		return $info;
	}

}
?>