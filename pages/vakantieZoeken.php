<div class="right" id="main-content-right">
<?PHP //hotels ophalen 
$hotels = array();

	if(isset($_POST['zoekSubmit'])){
		$_SESSION['vanDatum'] 		= $_POST['vanDatum'];
		$_SESSION['totDatum'] 		= $_POST['totDatum'];
		$_SESSION['bestemming'] 	= $_POST['bestemming'];
		$_SESSION['aantalPersonen'] = $_POST['aantalPersonen'];
		$_SESSION['formValid']		= false;

		//validate
		$_SESSION['formValid']		= true;
}
if(isset($_SESSION['formValid']) && $_SESSION['formValid']) {
	$client	= new SoapClient("http://tomcat.dkmedia.nl/hotelservice/hotelservice?wsdl");

		$req 					= new stdClass();
		$req->city 				= $_SESSION['bestemming'];
		$req->numberOfPersons 	= $_SESSION['aantalPersonen'];
		$req->fromDate 			= $_SESSION['vanDatum'];
		$req->toDate 			= $_SESSION['totDatum'];
		
		try {
			$result	= $client->FindAvailableHotels($req);
			if(is_array($result->hotels->hotel)) {
				foreach ($result->hotels->hotel as $value) {
					$hotels[] = $value;
				}
			} else {
				$hotels[] = $result->hotels->hotel;
			}
		} catch(Exception $e) {
			echo '<div class="errormessage" id="notification">'.$e->detail->fault->message.'</div>';
			//$e->detail->fault->message.
		}
}
?>

	<form id="vakantieForm" method="post">
		<label>Van </label>	
		<input name="vanDatum" class="datepicker" type="text" value="<?PHP echo $_SESSION['vanDatum'] == ''? '' : $_SESSION['vanDatum'] ?>"/>
		
		<label>Tot </label>
		<input name="totDatum" class="datepicker" type="text" value="<?PHP echo $_SESSION['totDatum'] == ''? '' : $_SESSION['totDatum'] ?>"/>

		<label>Bestemming </label> 
		<input name="bestemming" type="text" value="<?PHP echo $_SESSION['bestemming'] == ''? '' : $_SESSION['bestemming'] ?>"/>

		<label>Aantal personen </label> 
		<input name="aantalPersonen" width="4" type="text" value="<?PHP echo $_SESSION['aantalPersonen'] == ''? '' : $_SESSION['aantalPersonen'] ?>"/>
		
		<input name="zoekSubmit" type="submit" name="vakantieZoeken" value="Zoeken">
	</form>

	<table>
		<?PHP foreach ($hotels as $hotel): ?>
			<tr>
				<td><h3><?PHP echo $hotel->name ?></h3></td>
			</tr>
			<tr>
				<td rowspan="3">
				<?PHP
				if(is_array($hotel->photos->photo)) {
					$photoUrl = $hotel->photos->photo[0]->url;
				} else {
					$photoUrl = $hotel->photos->photo->url;
				}
				?>
				<img src="<?PHP echo $photoUrl ?>" style="max-width: 150px; max-height: 150px;">
			</td>
			</tr>
			<tr>
				<td><?PHP echo strlen($hotel->description) > 350 ? substr($hotel->description, 0, 350).'...' : $hotel->description  ?></td>
			</tr>
			<tr>
				<td>
					<a class="button" href="index.php?page=boekHotel&hotel=<?PHP echo $hotel->ID ?>">Boeken</a>
					Vanaf: <?PHP echo $hotel->fromPrice ?> Euro.
				</td>
			</tr>
		<?PHP endforeach; ?>
	</table>

</div>
<div class="clear"></div>