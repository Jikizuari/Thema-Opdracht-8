<div class="right" id="main-content-right">
	<div class="left" id="main-content-content">
		<h1><strong>Stel</strong> uw vakantie samen - <strong>Vlucht boeken</strong></h1>
<?PHP
$flights = array();

if(isset($_POST['submit'])){
	$_SESSION['vertrekhaven'] 		= $_POST['vertrekhaven'];
	$_SESSION['bestemming'] 		= $_POST['bestemming'];
	$_SESSION['vertrekDatum'] 		= $_POST['vertrekDatum'];
	$_SESSION['aankomstDatum'] 		= $_POST['aankomstDatum'];
	$_SESSION['aantalPersonen']		= $_POST['aantalPersonen'];
	$_SESSION['formValid']			= true;
}
if(isset($_SESSION['formValid']) && $_SESSION['formValid']) {
	$client	= new SoapClient("http://tomcat.dkmedia.nl/flightservice/flightservice?wsdl");

	$req 						= new stdClass();
	$req->departureAirport 		= $_SESSION['vertrekhaven'];
	$req->arrivalAirport 		= $_SESSION['bestemming'];
	$req->departureDate 		= $_SESSION['vertrekDatum'];
	$req->arrivalDate 			= $_SESSION['aankomstDatum'];

	try {
		$result	= $client->searchFlight($req);
		//var_dump($result);
		$_SESSION['stap1']			= true;
		if(is_array($result->return)) {
			foreach ($result->return as $vlucht) {
				$flights[] = $vlucht;
			}
		} else {
			$flights[] = $result->return;
		}
	} catch(Exception $e) {
		echo '<div class="errormessage" id="notification">'.$e->detail->fault->message.'</div>';
			//$e->detail->fault->message.
	}
}
?>

<form id="registerForm" name="vluchtForm" method="post">
	<label>Vertrekhaven</label>	
		<span>Van waar wilt u vertrekken?</span>
	<input name="vertrekhaven" type="text"/>

	<label>Bestemming</label>
		<span>Waar wilt u heen?</span>
	<input name="bestemming"  type="text"/>

	<label>Vertrekdatum</label> 
		<span>Wanneer wilt u vertrekken?</span>
	<input name="vertrekDatum" class="datepicker" type="text" />

	<label>Aankomstdatum</label> 
		<span>Wanneer hoopt u aan te komen?</span>
	<input name="aankomstDatum" class="datepicker" type="text" />

	<label>Aantal personen</label> 
		<span>Met hoeveel personen wilt u gaan?</span>
	<input name="aantalPersonen" type="text" />

	<button class="right button" type="submit" name="submit" >Zoeken</button>
</form>
<p>
	<?PHP if(isset($flights)) { ?>
	 	<h1><strong>Gevonden</strong> vluchten (<?PHP echo count($flights); ?>)</h1>
	 <?PHP } ?>
	<table>
		<?PHP foreach ($flights as $flight): ?>
			<tr>
				<td width="230px"><span>Vluchtcode:</span> <?PHP echo $flight->flightCode ?></td>
				<td><span>Maatschappij:</span> <?PHP echo $flight->airline ?></td>
			</tr>
			<tr>
				<td><span>Vertrekhaven:</span> <?PHP echo $flight->arrivalAirport->name ?></td>
				<td><span>Bestemming:</span> <?PHP echo $flight->departureAirport->name ?></td>
			</tr>
			<tr>
				<td><span>Vliegtuigtype:</span> <?PHP echo $flight->airplane->type ?></td>
				<td><span>Capaciteit:</span> <?PHP echo $flight->airplane->capacity ?> personen</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><a class="right button" href="?page=vakantieZoeken&vlucht=<?PHP echo $flight->flightId; ?>">Kiezen</a></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		<?PHP endforeach; ?>
	</table>
</p>
</div>
</div>
<div class="clear"></div>