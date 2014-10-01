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
					var_dump($_FILES);
					if( move_uploaded_file($_FILES["logo"]["tmp_name"], "media/".$_POST["nick"]."/image/".$_FILES["logo"]["name"]) ){
						$data["logo"] = "media/".$_POST["nick"]."/image/".$_FILES["logo"]["name"];
					}
				}
				if(!file_exists($path."/map")){
					mkdir($path."/map");
				}
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
		$pagina = $this->replace_content('/\#{USEDTAGS}\#/ms' ,$used_tags , $pagina);
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

		/*
		$pagina = $this->replace_content('/\#{NOTIFICATION.SUCCESS-CHANGE_PASSWORD}\#/ms', $language[$lan]["notifications"]["SUCCESS-CHANGE_PASSWORD"], $pagina);
		$pagina = $this->replace_content('/\#{NOTIFICATION.SUCCESS-NEW_TAG}\#/ms', $language[$lan]["notifications"]["SUCCESS-NEW_TAG"], $pagina);
		$pagina = $this->replace_content('/\#{NOTIFICATION.SUCCESS-EDIT_TAG}\#/ms', $language[$lan]["notifications"]["SUCCESS-EDIT_TAG"], $pagina);
		$pagina = $this->replace_content('/\#{NOTIFICATION.SUCCESS-FILE_UPLOAD}\#/ms', $language[$lan]["notifications"]["SUCCESS-FILE_UPLOAD"], $pagina);
		$pagina = $this->replace_content('/\#{NOTIFICATION.SUCCESS-FILE_RESTRICTION}\#/ms', $language[$lan]["notifications"]["SUCCESS-FILE_RESTRICTION"], $pagina);
		$pagina = $this->replace_content('/\#{NOTIFICATION.ERROR-CHANGE_PASSWORD}\#/ms', $language[$lan]["notifications"]["ERROR-CHANGE_PASSWORD"], $pagina);
		$pagina = $this->replace_content('/\#{NOTIFICATION.ERROR-EDIT_TAG}\#/ms', $language[$lan]["notifications"]["ERROR-EDIT_TAG"], $pagina);
		$pagina = $this->replace_content('/\#{NOTIFICATION.ERROR-INCOMPLETE_TAG}\#/ms', $language[$lan]["notifications"]["ERROR-INCOMPLETE_TAG"], $pagina);
		$pagina = $this->replace_content('/\#{NOTIFICATION.ERROR-EDIT_INCOMPLETE}\#/ms', $language[$lan]["notifications"]["ERROR-EDIT_INCOMPLETE"], $pagina);
		$pagina = $this->replace_content('/\#{NOTIFICATION.ERROR-MEDIADIRECTORY}\#/ms', $language[$lan]["notifications"]["ERROR-MEDIADIRECTORY"], $pagina);
		$pagina = $this->replace_content('/\#{NOTIFICATION.ERROR-USER_SPACE}\#/ms', $language[$lan]["notifications"]["ERROR-USER_SPACE"], $pagina);
		$pagina = $this->replace_content('/\#{NOTIFICATION.ERROR-FILE_UPLOAD}\#/ms', $language[$lan]["notifications"]["ERROR-FILE_UPLOAD"], $pagina);
		$pagina = $this->replace_content('/\#{NOTIFICATION.ERROR-NUM_TAGS}\#/ms', $language[$lan]["notifications"]["ERROR-NUM_TAGS"], $pagina);
		*/

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

		$pagina = $this->replace_content('/\#{GENERAL.HOME}\#/ms', $language[$lan]["general"]["HOME"], $pagina);
		$pagina = $this->replace_content('/\#{GENERAL.MULTIMEDIA}\#/ms', $language[$lan]["general"]["MULTIMEDIA"], $pagina);
		$pagina = $this->replace_content('/\#{GENERAL.LOGOUT}\#/ms', $language[$lan]["general"]["LOGOUT"], $pagina);
		
		if ($section === "index") {
			$pagina = $this->replace_content('/\#{INDEX.ACTIVE}\#/ms', $language[$lan][$section]["ACTIVE"], $pagina);
			$pagina = $this->replace_content('/\#{INDEX.INACTIVE}\#/ms', $language[$lan][$section]["INACTIVE"], $pagina);
			$pagina = $this->replace_content('/\#{INDEX.SEARCH-PLACEHOLDER}\#/ms', $language[$lan][$section]["SEARCH-PLACEHOLDER"], $pagina);
			$pagina = $this->replace_content('/\#{INDEX.ADDTAG}\#/ms', $language[$lan][$section]["ADDTAG"], $pagina);
			$pagina = $this->replace_content('/\#{INDEX.DISABLE}\#/ms', $language[$lan][$section]["DISABLE"], $pagina);
			$pagina = $this->replace_content('/\#{INDEX.ENABLE}\#/ms', $language[$lan][$section]["ENABLE"], $pagina);
			$pagina = $this->replace_content('/\#{INDEX.COPY}\#/ms', $language[$lan][$section]["COPY"], $pagina);
			$pagina = $this->replace_content('/\#{INDEX.EDIT}\#/ms', $language[$lan][$section]["EDIT"], $pagina);
			$pagina = $this->replace_content('/\#{INDEX.DELETE}\#/ms', $language[$lan][$section]["DELETE"], $pagina);
		}elseif ($section === "addtag") {
			$pagina = $this->replace_content('/\#{ADDTAG.BACK}\#/ms', $language[$lan][$section]["BACK"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.NEXT}\#/ms', $language[$lan][$section]["NEXT"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.TITLE-LOCATION}\#/ms', $language[$lan][$section]["TITLE-LOCATION"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.SEARCH}\#/ms', $language[$lan][$section]["SEARCH"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.LATITUDE}\#/ms', $language[$lan][$section]["LATITUDE"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.LONGITUDE}\#/ms', $language[$lan][$section]["LONGITUDE"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.TITLE-GENERAL}\#/ms', $language[$lan][$section]["TITLE-GENERAL"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.TAGNAME}\#/ms', $language[$lan][$section]["TAGNAME"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.TAGNAME-TOOLTIP}\#/ms', $language[$lan][$section]["TAGNAME-TOOLTIP"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.TAGDESC}\#/ms', $language[$lan][$section]["TAGDESC"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.TAGDESC-TOOLTIP}\#/ms', $language[$lan][$section]["TAGDESC-TOOLTIP"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.WEBSITE}\#/ms', $language[$lan][$section]["WEBSITE"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.WEBSITE-TOOLTIP}\#/ms', $language[$lan][$section]["WEBSITE-TOOLTIP"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.PURCHASEURL}\#/ms', $language[$lan][$section]["PURCHASEURL"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.PURCHASEURL-TOOLTIP}\#/ms', $language[$lan][$section]["PURCHASEURL-TOOLTIP"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.TITLE-SOCIAL}\#/ms', $language[$lan][$section]["TITLE-SOCIAL"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.TITLE-IMAGE}\#/ms', $language[$lan][$section]["TITLE-IMAGE"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.DRAG-IMAGE}\#/ms', $language[$lan][$section]["DRAG-IMAGE"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.TITLE-VIDEO}\#/ms', $language[$lan][$section]["TITLE-VIDEO"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.DRAG-VIDEO}\#/ms', $language[$lan][$section]["DRAG-VIDEO"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.TITLE-AUDIO}\#/ms', $language[$lan][$section]["TITLE-AUDIO"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.DRAG-AUDIO}\#/ms', $language[$lan][$section]["DRAG-AUDIO"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.UPLOAD-PC}\#/ms', $language[$lan][$section]["UPLOAD-PC"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.UPLOAD-CLOUD}\#/ms', $language[$lan][$section]["UPLOAD-CLOUD"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.TITLE-SELECTFILE}\#/ms', $language[$lan][$section]["TITLE-SELECTFILE"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.BUTTON-SELECT}\#/ms', $language[$lan][$section]["BUTTON-SELECT"], $pagina);
			$pagina = $this->replace_content('/\#{ADDTAG.BUTTON-CANCEL}\#/ms', $language[$lan][$section]["BUTTON-CANCEL"], $pagina);
		}elseif ($section === "multimedia") {
			$pagina = $this->replace_content('/\#{MULTIMEDIA.TITLE-FILES}\#/ms', $language[$lan][$section]["TITLE-FILES"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.NAME}\#/ms', $language[$lan][$section]["NAME"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.SIZE}\#/ms', $language[$lan][$section]["SIZE"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.DATEUPLOADED}\#/ms', $language[$lan][$section]["DATEUPLOADED"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.ACTION}\#/ms', $language[$lan][$section]["ACTION"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.BUTTON-DELETE}\#/ms', $language[$lan][$section]["BUTTON-DELETE"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.MENU-VIDEO}\#/ms', $language[$lan][$section]["MENU-VIDEO"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.MENU-IMAGE}\#/ms', $language[$lan][$section]["MENU-IMAGE"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.MENU-AUDIO}\#/ms', $language[$lan][$section]["MENU-AUDIO"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.SEARCH-PLACEHOLDER}\#/ms', $language[$lan][$section]["SEARCH-PLACEHOLDER"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.UPLOADFILE}\#/ms', $language[$lan][$section]["UPLOADFILE"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.TITLE-OVERVIEW}\#/ms', $language[$lan][$section]["TITLE-OVERVIEW"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.USEDSPACE}\#/ms', $language[$lan][$section]["USEDSPACE"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.FILES-VIDEO}\#/ms', $language[$lan][$section]["FILES-VIDEO"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.FILES-IMAGE}\#/ms', $language[$lan][$section]["FILES-IMAGE"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.FILES-AUDIO}\#/ms', $language[$lan][$section]["FILES-AUDIO"], $pagina);
			$pagina = $this->replace_content('/\#{MULTIMEDIA.FILES-TOTAL}\#/ms', $language[$lan][$section]["FILES-TOTAL"], $pagina);
		}elseif ($section === "profile") {
			$pagina = $this->replace_content('/\#{PROFILE.PICTURE}\#/ms', $language[$lan][$section]["PICTURE"], $pagina);
			$pagina = $this->replace_content('/\#{PROFILE.DETAIL}\#/ms', $language[$lan][$section]["DETAIL"], $pagina);
			$pagina = $this->replace_content('/\#{PROFILE.USEDPLACES}\#/ms', $language[$lan][$section]["USEDPLACES"], $pagina);
			$pagina = $this->replace_content('/\#{PROFILE.USEDSPACE}\#/ms', $language[$lan][$section]["USEDSPACE"], $pagina);
			$pagina = $this->replace_content('/\#{PROFILE.PASSWORD-CHANGE}\#/ms', $language[$lan][$section]["PASSWORD-CHANGE"], $pagina);
			$pagina = $this->replace_content('/\#{PROFILE.PASSWORD-CURRENT}\#/ms', $language[$lan][$section]["PASSWORD-CURRENT"], $pagina);
			$pagina = $this->replace_content('/\#{PROFILE.PASSWORD-NEW}\#/ms', $language[$lan][$section]["PASSWORD-NEW"], $pagina);
			$pagina = $this->replace_content('/\#{PROFILE.PASSWORD-CONFIRM}\#/ms', $language[$lan][$section]["PASSWORD-CONFIRM"], $pagina);
			$pagina = $this->replace_content('/\#{PROFILE.PASSWORD-CHANGE}\#/ms', $language[$lan][$section]["PASSWORD-CHANGE"], $pagina);
			$pagina = $this->replace_content('/\#{PROFILE.VAL-MIN6}\#/ms', $language[$lan][$section]["VAL-MIN6"], $pagina);
			$pagina = $this->replace_content('/\#{PROFILE.LANGUAGE}\#/ms', $language[$lan][$section]["LANGUAGE"], $pagina);
			$pagina = $this->replace_content('/\#{PROFILE.LANGUAGE-SPANISH}\#/ms', $language[$lan][$section]["LANGUAGE-SPANISH"], $pagina);
			$pagina = $this->replace_content('/\#{PROFILE.LANGUAGE-ENGLISH}\#/ms', $language[$lan][$section]["LANGUAGE-ENGLISH"], $pagina);
			$pagina = $this->replace_content('/\#{PROFILE.LANGUAGE-SELECT}\#/ms', $language[$lan][$section]["LANGUAGE-SELECT"], $pagina);
		}elseif ($section === "edittag") {
			
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