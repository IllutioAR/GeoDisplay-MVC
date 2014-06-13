<?php

require '../app/model/tag.model.php';
require '../app/model/client.model.php';

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

		$pagina = $this->load_template("Index", "en", "index.css");
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
		$tag = new tag();
		if( $active == 1 ){
			$tsArray = $tag->get_tags($_SESSION["client"]["nick"],9,1); // 9 es el número de tags a mostrar, el 1 son los activos
		}
		elseif ( $active == 0 ){
			$tsArray = $tag->get_tags($_SESSION["client"]["nick"],9,0); // 9 es el número de tags a mostrar, el 0 son los inactivos
		}
		else{
			$tsArray = "";
		}
		

		if($tsArray != ""){
			include "../app/views/default/modules/tags/tags.php";
			$table = ob_get_clean();
			$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms', $table , $pagina);
		}else{
			$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms' ,"<h1>No hay tags</h1>" , $pagina);
		}
		$this->view_page($pagina);
	}

	function profile(){
		$this->validate_session();
		if( isset($_POST["password_form"]) && isset($_POST["password"]) && isset($_POST["new_password"]) && isset($_POST["new_password_confirm"]) ){
			$client = new client();
			$changed = $client->change_password($_SESSION["client"]["email"], $_POST["password"], $_POST["new_password"], $_POST["new_password_confirm"]);
			if ( $changed )
				header("Location: profile.php?success=password");
		}
		else{	// No existe ningún post de formularios muestra la vista normal

			$pagina = $this->load_template("Profile", "en", "profile.css");
			$contenido = $this->load_page('../app/views/default/modules/profile/profile.php');
			$pagina = $this->replace_content('/\#{MENU}\#/ms' , "", $pagina);
			$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms' ,$contenido , $pagina);
			$this->view_page($pagina);
		}
	}

	function add_tag(){
		$this->validate_session();

		$pagina = $this->load_template("Add tag", "en", "addtag.css");
		$menu = $this->load_page('../app/views/default/modules/addtag/menu.php');
		$pagina = $this->replace_content('/\#{MENU}\#/ms' ,$menu , $pagina);
		$form = $this->load_page('../app/views/default/modules/addtag/form.php');
		$pagina = $this->replace_content('/\#{CONTENIDO}\#/ms', $form , $pagina);
		
		$this->view_page($pagina);
	}

	function principal()
	{
		$pagina=$this->load_template('Index', 'en', 'index.css');
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