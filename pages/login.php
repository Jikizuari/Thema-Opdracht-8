<div class="right" id="main-content-right">
	<div class="left" id="main-content-content">
		<h1><strong>Log </strong>in</h1>

		
		<?php
		if(isset($_POST['submit'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];

			$client						= new SoapClient("http://tomcat.dkmedia.nl/tho8/userservice?wsdl");

			try {
				$result	= $client->UserLogin(array('E-mail'=>$username, 'Password'=>$password));
				$_SESSION['user_id'] = $result->UserID;
				$_SESSION['user_name'] = $result->Name;
				$_SESSION['user_lastname'] = $result->LastName;

				if(isset($_SESSION['stap1']) && $_SESSION['stap1']){
					redirect("vakantie");
				} else{
					redirect();
				}
			} catch(Exception $e) {
				require_once('essentials/usererror.php');
				$u = new userError();
				$errorMessage = $u->getErrorMessage($e->detail->fault->errorCode);
				echo '<div class="errormessage" id="notification">'.$errorMessage.'</div>';
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
	