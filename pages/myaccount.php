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
				$DateOfBirth = $output->DateOfBirth;
				$DateOfBirth = str_replace("Z", "", $DateOfBirth);
			} catch(Exception $e) {
				require_once('essentials/usererror.php');
				$u = new userError();
				$errorMessage = $u->getErrorMessage($e->detail->fault->errorCode);
				echo '<div class="errormessage" id="notification">'.$errorMessage.'</div>';
			}
		?>
		<table id="tableStyle">
			<tr><td><span>Klantnummer</span> <?php echo $output->UserID ?></td><td><span>Woonplaats</span> <?php echo $output->City ?></td></tr>
			<tr><td><span>Voornaam</span> <?php echo $output->Name ?></td><td><span>Geboortedatum</span> <?php echo $DateOfBirth ?></td></tr>
			<tr><td><span>Achternaam</span> <?php echo $output->LastName ?></td><td><span>Telnummer</span> <?php echo $output->PhoneNumber ?></td></tr>
			<tr><td><span>Straat</span> <?php echo $output->Street ." ". $output->HouseNumber ?></td><td><span>E-mailadres</span> <?php echo $output->{'E-mail'} ?></td></tr>
			<tr><td><span>Postcode</span> <?php echo $output->ZipCode ?></td><td></td></tr>
		</table>
		<a class="right button" href="?page=editaccount">Edit gegevens</a> <a class="right button" href="?page=myholidays">Mijn boekingen</a>
	</div>
	<?PHP require_once("essentials/sidebar.php"); ?>
</div>
<div class="clear"></div>
	