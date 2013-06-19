<div class="right" id="main-content-right">
<?PHP //hotels ophalen 
$hotels = array();

if(isset($_GET['vlucht'])){
	$_SESSION['vlucht_id'] = $_GET['vlucht']; 
	$_SESSION['stap1']		= true;
}
if(isset($_SESSION['stap1']) && $_SESSION['stap1']) {
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
<a class="right button" href="index.php?page=cancel">Annuleer</a>
</div>
<div class="clear"></div>