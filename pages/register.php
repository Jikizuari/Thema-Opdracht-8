<div class="right" id="main-content-right">
	<div class="left" id="main-content-content">
		<h1><strong>Create</strong> a new account</h1>

		
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

			$addRequest 				= new stdClass();
			$addRequest->Name 			= $name;
			$addRequest->Lastname		= $lname;
			$addRequest->Street 		= $street;
			$addRequest->HouseNumber 	= $housenmb;
			$addRequest->ZipCode 		= $zipcode;
			$addRequest->Address 		= $addr;
			$addRequest->DateOfBirth 	= $birth;
			$addRequest->PhoneNumber	= $phone;
			$addRequest->{'E-mail'}		= $email;
			$addRequest->Password 		= $pass;

			try {
				$result	= $client->UserRegistration(array('Name'=>$name, 'Lastname'=>$lname, 'Street'=>$street, 'HouseNumber'=>$housenmb, 'ZipCode'=>$zipcode, 'City'=>$addr, 'DateOfBirth'=>$birth, 'PhoneNumber'=>$phone, 'E-mail'=>$email, 'Password'=>$pass));
				redirect('login');
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
				<input type="text" id="name" name="name" />

				<label class="label">Achternaam</label>
					<span>Uw achternaam</span>
				<input type="text" id="lname" name="lname" />

				<label class="label">Adres</label>
					<span>Uw adres</span>
				<input type="text" id="street" name="street" />

				<label class="label">Huisnummer</label>
					<span>Uw huisnummer</span>
				<input type="text" id="housenmb" name="housenmb" />

				<label class="label">Postcode</label>
					<span>(bijv. 1111AA)</span>
				<input type="text" id="zip" name="zip" />

				<label class="label">Stad</label>
					<span>De stad waar u in woont</span>
				<input type="text" id="addr" name="addr" />

				<label class="label">Geboortedatum</label>
					<span>(bijv. 1993-09-22)</span>
				<input type="text" id="birth" name="birth" />

				<label class="label">Telefoonnummer</label>
					<span>Uw telefoonnummer</span>
				<input type="text" id="phone" name="phone" />

				<label class="label">E-mail</label>
					<span>Dit wordt uw inlognaam</span>
				<input type="text" id="mail" name="mail" />

				<label class="label">Wachtwoord</label>
					<span>Kies een wachtwoord</span>
				<input type="password" id="pass" name="pass" />

			<button class="right button" type="submit" name="submit" >Registreer</button>
		</form>
	</div>
	<?PHP require_once("essentials/sidebar.php"); ?>
</div>
<div class="clear"></div>
	