<?php
$getpage = isset($_GET['page']) ? $_GET['page'] : "";

	switch($getpage){
		case NULL:
			header('Location: ?page=index');
			break;
		case "register":
			$thisPage = "Register";
			$getpage = "pages/register";
			break;
		case "login":
			$thisPage = "Login";
			$getpage = "pages/login";
			break;
		case "index":
		default:
			$thisPage = "Home";
			$getpage = "pages/index";
			break;
	}

require_once("essentials/header.php");
require_once($getpage.".php");
require_once("essentials/sidebar.php");
require_once("essentials/footer.php");
?>