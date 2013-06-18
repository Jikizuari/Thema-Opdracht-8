<div class="right" id="main-content-right">
<?PHP
if(isset($_GET['roomType']) && isset($_GET['numberOfRooms'])) {
	$_SESSION['hotel_roomType'] = $_GET['roomType'];
	$_SESSION['hotel_numberOfRooms'] = $_GET['numberOfRooms'];
	$_SESSION['stap3'] = true;
}
//http://iis.dkmedia.nl/TO8.VervoerService.svc?wsdl
if(isset($_SESSION['stap3']) && $_SESSION['stap3']) {
	$client	= new SoapClient("http://iis.dkmedia.nl/TO8.VervoerService.svc?wsdl");
	$req 					= new stdClass();
	$req->numP 	= $_SESSION['aantalPersonen'];

	try {
			$result	= $client->GetAvailableCars($req);
			var_dump($result);

	} catch(Exception $e) {
		echo '<div class="errormessage" id="notification">'.$e->detail->fault->message.'</div>';
		//$e->detail->fault->message.
	}


} elseif(isset($_SESSION['stap2']) && $_SESSION['stap2']) {
	redirect("boekHotel&hotel=".$_SESSION['hotel_id']);
} else {
	redirect("vakantieZoeken");
}
?>
</div>
<div class="clear"></div>