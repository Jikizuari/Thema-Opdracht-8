<div class="right" id="main-content-right">
	<div class="left" id="main-content-content">
		<h1><strong>Wijzig</strong> uw persoonsgegevens</h1>

		
		<?php
		if(isset($_POST['submit'])) {
			$name 		= $_POST['name'];
			$lname 		= $_POST['lname'];
			$street 	= $_POST['street'];
			$housenmb 	= $_POST['housenmb'];
			$zipcode 	= $_POST['zip'];
			$addr 		= $_POST['addr'];
			$birth 		= $_POST['birth'];
			$phone 		= $_POST['phone'];
			$email 		= $_POST['mail'];
			$pass 		= $_POST['pass'];

			$client						= new SoapClient("http://tomcat.dkmedia.nl/tho8/userservice?wsdl");

			try {
				if (isset($pass)) {
					$result	= $client->UpdateUser(array('UserID'=>$_SESSION['user_id'], 'Name'=>$name, 'Lastname'=>$lname, 'Street'=>$street, 'HouseNumber'=>$housenmb, 'ZipCode'=>$zipcode, 'City'=>$addr, 'DateOfBirth'=>$birth, 'PhoneNumber'=>$phone, 'E-mail'=>$email, 'Password'=>$pass));
				} else {
					$result	= $client->UpdateUser(array('UserID'=>$_SESSION['user_id'], 'Name'=>$name, 'Lastname'=>$lname, 'Street'=>$street, 'HouseNumber'=>$housenmb, 'ZipCode'=>$zipcode, 'City'=>$addr, 'DateOfBirth'=>$birth, 'PhoneNumber'=>$phone, 'E-mail'=>$email));
				}
				if($result->ActionProcessed){
					$_SESSION['user_name'] = $_POST['name'];
					$_SESSION['user_lastname'] = $_POST['lname'];
					redirect('myaccount');
				} else {
					echo '<div class="errormessage" id="notification">Er is wat mis gegaan.</div>';
				}
			} catch(Exception $e) {
				require_once('essentials/usererror.php');
				$u = new userError();
				$errorMessage = $u->getErrorMessage($e->detail->fault->errorCode);
				echo '<div class="errormessage" id="notification">'.$errorMessage.'</div>';
			}
		} else {
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
		}
		?>
		<form id="registerForm" name="registerForm" action="" method="post">

				<label class="label">Naam</label>
					<span>Uw voornaam</span>
				<input type="text" id="name" name="name" value="<?php if(isset($_POST['submit'])) { echo $_POST['name']; } else { echo $output->Name; } ?>" />

				<label class="label">Achternaam</label>
					<span>Uw achternaam</span>
				<input type="text" id="lname" name="lname" value="<?php if(isset($_POST['submit'])) { echo $_POST['lname']; } else { echo $output->LastName; } ?>" />

				<label class="label">Adres</label>
					<span>Uw adres</span>
				<input type="text" id="street" name="street" value="<?php if(isset($_POST['submit'])) { echo $_POST['street']; } else { echo $output->Street; } ?>" />

				<label class="label">Huisnummer</label>
					<span>Uw huisnummer</span>
				<input type="text" id="housenmb" name="housenmb" value="<?php if(isset($_POST['submit'])) { echo $_POST['housenmb']; } else { echo $output->HouseNumber; } ?>" />

				<label class="label">Postcode</label>
					<span>(bijv. 1111AA)</span>
				<input type="text" id="zip" name="zip" value="<?php if(isset($_POST['submit'])) { echo $_POST['zip']; } else { echo $output->ZipCode; } ?>" />

				<label class="label">Woonplaats</label>
					<span>Uw huidige woonplaats</span>
				<input type="text" id="addr" name="addr" value="<?php if(isset($_POST['submit'])) { echo $_POST['addr']; } else { echo $output->City; } ?>" />

				<label class="label">Geboortedatum</label>
					<span>(bijv. 1993-09-22)</span>
				<input type="text" id="birth" name="birth" value="<?php if(isset($_POST['submit'])) { echo $_POST['birth']; } else { echo $DateOfBirth; } ?>" />

				<label class="label">Telefoonnummer</label>
					<span>Uw telefoonnummer</span>
				<input type="text" id="phone" name="phone" value="<?php if(isset($_POST['submit'])) { echo $_POST['phone']; } else { echo $output->PhoneNumber; } ?>" />

				<label class="label">E-mail</label>
					<span>Dit is uw inlognaam</span>
				<input type="text" id="mail" name="mail" value="<?php if(isset($_POST['submit'])) { echo $_POST['mail']; } else { echo $output->{'E-mail'}; } ?>" />

				<label class="label">Wachtwoord</label>
					<span>Is niet verplicht</span>
				<input type="password" id="pass" name="pass" />

			<button class="right button" type="submit" name="submit" >Opslaan</button>
		</form>
	</div>
	<?PHP require_once("essentials/sidebar.php"); ?>
</div>
<div class="clear"></div>
	