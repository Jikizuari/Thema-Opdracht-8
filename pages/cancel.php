<div class="right" id="main-content-right">
	<div class="left" id="main-content-content">
		<h1><strong>Bezig</strong>  met annuleren...</h1>
		<?php

			$user_id = $_SESSION['user_id'];
			$user_name = $_SESSION['user_name'];
			$user_lastname = $_SESSION['user_lastname'];
			
			session_destroy();
			session_start();

			$_SESSION['user_id'] = $user_id;
			$_SESSION['user_name'] = $user_name;
			$_SESSION['user_lastname'] = $user_lastname;
			
			redirect();
		?>
	</div>
	<?PHP require_once("essentials/sidebar.php"); ?>
</div>
<div class="clear"></div>
	