<div class="right" id="main-content-right">
	<div class="left" id="main-content-content">
		<h1><strong>Mijn </strong>account</h1>
		<?php

			ini_set('display_errors',1); 
			error_reporting(E_ALL);

			$client	= new SoapClient("http://tomcat.dkmedia.nl/tho8/userservice?wsdl");
			$output	= "";

			try {
				$output = $client->GetUserData(array('UserID'=>$_SESSION['user_id']));
			} catch(Exception $e) {
				require_once('essentials/usererror.php');
				$u = new userError();
				$errorMessage = $u->getErrorMessage($e->detail->fault->errorCode);
				echo '<div class="errormessage" id="notification">'.$errorMessage.'</div>';
			}
		?>
		<?php var_dump($output) ?>
	</div>
	<?PHP require_once("essentials/sidebar.php"); ?>
</div>
<div class="clear"></div>
	