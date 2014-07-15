<?php

require '../app/model/tag.model.php';
require '../app/model/client.model.php';
require '../app/model/multimedia.model.php';

class mvc_controller {

	// Método que valida la sesión del usuario, si la sesión no es válida redirige automáticamente al login.
	function validate_session(){
		session_start();
		if( isset($_SESSION["logged"]) && $_SESSION["logged"] ){
			return true;
		}
		header("Location: login.php");
	}

	// Muestra la vista de login, es el único método que valida la session por sí mismo sin utilizar el método validate_session()
	function login(){
		session_start();
		if( isset($_POST["email"]) && isset($_POST["password"]) ){
			$user = new client();
			$_SESSION["logged"] = $user->validate_client( $_POST["email"], $_POST["password"] );
			if($_SESSION["logged"]) {
				$_SESSION["client"] = $user->get_client_data( $_POST["email"] )[0];
				header("Location: index.php");
			}else{
				header("Location: login.php?error");
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

		$pagina = $this->load_template("Index", "es", "index.css");
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
		$this->view_page($pagina);
	}

	function get_plan_info($plan){
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

	function profile(){
		$this->validate_session();
		if( isset($_POST["password_form"]) && isset($_POST["password"]) && isset($_POST["new_password"]) && isset($_POST["new_password_confirm"]) ){
			$client = new client();
			$changed = $client->change_password($_SESSION["client"]["email"], $_POST["password"], $_POST["new_password"], $_POST["new_password_confirm"]);
			if ( $changed )
				header("Location: profile.php?success=password");
			else 
				header("Location: profile.php?error");
		}
		else{	// No existe ningún post de formularios muestra la vista normal
			$pagina = $this->load_template("Profile", "es", "profile.css");
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
			$this->view_page($pagina);
		}
	}

	function add_tag(){
		$this->validate_session();

		$pagina = $this->load_template("Add tag", "es", "addtag.css");
		$menu = $this->load_page('../app/views/default/modules/addtag/menu.php');
		$pagina = $this->replace_content('/\#{MENU}\#/ms' ,$menu , $pagina);
		$form = $this->load_page('../app/views/default/modules/addtag/form.php');
		$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms', $form , $pagina);
		
		$this->view_page($pagina);
	}

	function edit_tag($id){
		$this->validate_session();

		$pagina = $this->load_template("Edit tag", "es", "edittag.css");
		$menu = $this->load_page('../app/views/default/modules/edittag/menu.php');
		$pagina = $this->replace_content('/\#{MENU}\#/ms' ,$menu , $pagina);

		ob_start();

		$tag = new tag($_SESSION["client"]["nick"]);
		
		$tag = $tag->get_full_data($id);
		
		if($tag == array()){
			header("Location: index.php?error=edit");
		}
		include "../app/views/default/modules/edittag/form.php";
		$form = ob_get_clean();
		$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms', $form , $pagina);

		$this->view_page($pagina);
	}

	function multimedia($type){
		$this->validate_session();

		$pagina = $this->load_template("Multimedia", "es", "media.css");
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
		

		$this->view_page($pagina);
	}

	function principal()
	{
		$pagina=$this->load_template('Index', 'es', 'index.css');
		$html = $this->load_page('../app/views/default/modules/tags.php');
		$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms' ,$html , $pagina);
		$this->view_page($pagina);
	}

	function load_template($title='', $lang='en', $css='index.css'){
		$pagina = $this->load_page('../app/views/default/page.php');
		$header = $this->load_page('../app/views/default/sections/header.php');
		$footer = $this->load_page('../app/views/default/sections/footer.php');
		$pagina = $this->replace_content('/\#{LANG}\#/ms' ,$lang , $pagina);
		$pagina = $this->replace_content('/\#{TITLE}\#/ms',$title , $pagina);
		$pagina = $this->replace_content('/\#{CSS}\#/ms' ,$css , $pagina);
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

}
?>