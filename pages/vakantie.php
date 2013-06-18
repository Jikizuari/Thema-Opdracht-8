<div class="right" id="main-content-right">
<?PHP

if(isset($_SESSION['stap5']) && $_SESSION['stap5'])
	redirect("boekVakantie");
elseif(isset($_SESSION['stap4']) && $_SESSION['stap4'])
	redirect("boekAttractie");
elseif(isset($_SESSION['stap3']) && $_SESSION['stap3'])
	redirect("huurAuto");
elseif(isset($_SESSION['stap2']) && $_SESSION['stap2'])
	redirect("boekHotel&hotel=".$_SESSION['hotel_id']);
elseif(isset($_SESSION['stap1']) && $_SESSION['stap1'])
	redirect("vakantieZoeken");
else
	redirect("vluchtZoeken");
?>
</div>
<div class="clear"></div>