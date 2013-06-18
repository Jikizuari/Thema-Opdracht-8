<div class="right" id="main-content-right">
<?PHP
$autos = array();

if(isset($_SESSION['stap2']) && $_SESSION['stap2'] && isset($_GET['roomType']) && isset($_GET['numberOfRooms'])) {
	$_SESSION['hotel_roomType'] = $_GET['roomType'];
	$_SESSION['hotel_numberOfRooms'] = $_GET['numberOfRooms'];
	$_SESSION['stap3'] = true;
}
if(isset($_SESSION['stap3']) && $_SESSION['stap3']) {
	$client	= new SoapClient("http://iis.dkmedia.nl/TO8.VervoerService.svc?wsdl");
	$req 					= new stdClass();
	$req->numP 	= $_SESSION['aantalPersonen'];

	try {
		$result	= $client->GetAvailableCars($req);
		if(isset($result->GetAvailableCarsResult->Car)) {
			if(is_array($result->GetAvailableCarsResult->Car)) {
				foreach ($result->GetAvailableCarsResult->Car as $value) {
					$autos[] = $value;
				}
			} else {
				$autos[] = $result->GetAvailableCarsResult->Car;
			}
		}
		if(empty($autos))
			redirect("boekAttractie");

	} catch(Exception $e) {
		echo '<div class="errormessage" id="notification">'.$e->detail->fault->message.'</div>';
	}

} elseif(isset($_SESSION['stap2']) && $_SESSION['stap2']) {
	redirect("boekHotel&hotel=".$_SESSION['hotel_id']);
} else {
	redirect("vakantieZoeken");
}
?>
<h1>Auto Huren</h1>
<table>
<?PHP foreach ($autos as $auto): ?>
	<tr>
		<td rowspan="5">
			<img src="<?PHP echo $auto->PhotoURL ?>" style="max-width: 150px; max-height: 150px; padding: 5px;">
		</td>
	</tr>
	<tr>
		<td collspan="2"><h3><?PHP echo $auto->Name ?></h3></td>
	</tr>
	<tr>
		<td>Aantal personen</td>
		<td><?PHP echo $auto->NumP  ?></td>
	</tr>
	<tr>
		<td>Prijs</td>
		<td><?PHP echo $auto->Price  ?> Euro</td>
	</tr>
	<tr>
		<td>
			<a class="button" href="index.php?page=boekAttractie&auto=<?PHP echo $auto->carId ?>">Huren</a>
		</td>
	</tr>
	<tr><td>&nbsp;&nbsp;</tr>
<?PHP endforeach; ?>
</table>
<hr />
<a class="button" href="index.php?page=cancel">Cancel</a> <a class="button" href="index.php?page=boekAttractie">Next</a>
</div>
<div class="clear"></div>