<div class="right" id="main-content-right">
	<div class="left" id="main-content-content">
		<h1><strong>Cancel</strong></h1>
		<?php

			$user_id = $_SESSION['user_id'];
			$user_name = $_SESSION['user_name'];
			$user_lastname = $_SESSION['user_lastname'];
			session_destroy();

			$_SESSION['user_id'] = $user_id;
			$_SESSION['user_name'] = $user_name;
			$_SESSION['user_lastname'] = $user_lastname;
			
		?>
		<meta http-equiv="refresh" content="0; URL=?page=index">
	</div>
	<?PHP require_once("essentials/sidebar.php"); ?>
</div>
<div class="clear"></div>
	