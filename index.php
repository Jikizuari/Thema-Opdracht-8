<?php session_start();
require_once("essentials/common.php");

$getpage = isset($_GET['page']) ? $_GET['page'] : "index";

$pageFile = "pages/".$getpage.".php";

if(!is_file($pageFile))
	$pageFile = "pages/404.php";

require_once("essentials/header.php");
require_once($pageFile);
// require_once("essentials/sidebar.php");
require_once("essentials/footer.php");
?>