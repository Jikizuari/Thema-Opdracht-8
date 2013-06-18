<div class="right" id="main-content-right">
	<div class="left" id="main-content-content">
		<h1><strong>Log </strong>in</h1>

		
		<?php
		if(isset($_POST['submit'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];

			$client						= new SoapClient("http://tomcat.dkmedia.nl/tho8/userservice?wsdl");

			$addRequest 				= new stdClass();
			$addRequest->{'E-mail'}		= $username;
			$addRequest->Password 		= $password;

			try {
				$result	= $client->UserLogin(array('E-mail'=>$username, 'Password'=>$password));
				$_SESSION['user_id'] = $result->UserID;
				$_SESSION['user_name'] = $result->Name;
				$_SESSION['user_lastname'] = $result->LastName;

				redirect("vakantie");
			} catch(Exception $e) {
				echo '<div class="errormessage" id="notification">'.$e->detail->fault->message.'</div>';
				//$e->detail->fault->message.
			}
		}
		?>
		<form id="registerForm" name="loginForm" action="" method="post">


				<label class="label">E-mail</label>
					<span>Uw e-mail adres</span>
				<input type="text" id="username" name="username" />

				<label class="label">Wachtwoord</label>
					<span>Uw wachtwoord</span>
				<input type="password" id="password" name="password" />
				Heeft u nog geen account? Klik <a href="?page=register">hier</a> om een gratis account aan te maken.
			<button class="right button" type="submit" name="submit" >Inloggen</button>
		</form>
	</div>

	</div>
<div class="clear"></div>
	