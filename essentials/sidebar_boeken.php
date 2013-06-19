<div class="right" id="main-content-sidebar">
	<h1><strong>Uw</strong> vordering</h1>
	<p class="sidebarBoeken">
		<span 
		<?php 
		if(isset($_SESSION['stap1'])) {
			echo ' class="sidebarActive"';
		} else {
			echo ' class="sidebarNonactive"';
		}
		?>
		>1</span> <a class="sidebarLink" href="?page=vluchtZoeken">Vluchtgegevens</a>
	</p>
	<p class="sidebarBoeken">
		<span
		<?php 
		if(isset($_SESSION['stap2'])) {
			echo ' class="sidebarActive"';
		} else {
			echo ' class="sidebarNonactive"';
		}
		?>
		>2</span> Hotelgegevens
	</p>
	<p class="sidebarBoeken">
		<span
		<?php 
		if(isset($_SESSION['stap3'])) {
			echo ' class="sidebarActive"';
		} else {
			echo ' class="sidebarNonactive"';
		}
		?>
		>3</span>	Vervoer
	</p>
	<p class="sidebarBoeken">
		<span
		<?php 
		if(isset($_SESSION['stap4'])) {
			echo ' class="sidebarActive"';
		} else {
			echo ' class="sidebarNonactive"';
		}
		?>
		>4</span>	Attracties
	</p>
	<p class="sidebarBoeken">
		<span 
		<?php 
		if(isset($_SESSION['stap5'])) {
			echo ' class="sidebarActive"';
		} else {
			echo ' class="sidebarNonactive"';
		}
		?>
		>5</span>	Verificatie
	</p>
</div>
<div class="clear"></div>
