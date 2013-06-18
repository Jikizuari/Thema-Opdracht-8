<div class="right" id="main-content-right">
<?php
	$rooms = array();
	$hotel = null;
	$client	= new SoapClient("http://tomcat.dkmedia.nl/hotelservice/hotelservice?wsdl");
	
	if(isset($_GET['hotel'])) { //check of hotel bestaat
		$_SESSION['stap2'] = false;
		$_SESSION['hotel_id'] = $_GET['hotel'];
		$req 					= new stdClass();
		
		$req->city 				= $_SESSION['bestemming'];
		$req->numberOfPersons 	= $_SESSION['aantalPersonen'];
		$req->fromDate 			= $_SESSION['vanDatum'];
		$req->toDate 			= $_SESSION['totDatum'];
		
		$hotels =  array();
		try {
			$result	= $client->FindAvailableHotels($req);
			if(is_array($result->hotels->hotel)) {
				foreach ($result->hotels->hotel as $value) {
					$hotels[] = $value;
				}
			} else {
				$hotels[] = $result->hotels->hotel;
			}
		} catch(Exception $e) {}
		
		foreach ($hotels as $h) {
			if($h->ID == $_SESSION['hotel_id'])
				$hotel = $h;
		}
		if($hotel == null)
			echo '<div class="errormessage" id="notification">Hotel niet gevonden!</div>';
		else 
			$_SESSION['stap2'] = true;
	}

	//Als hotel bestaat
	if(isset($_SESSION['stap2']) && $_SESSION['stap2']) {
		$req 					= new stdClass();
		$req->hotelId 			= $_SESSION['hotel_id'];
		$req->numberOfPersons 	= $_SESSION['aantalPersonen'];
		$req->fromDate 			= $_SESSION['vanDatum'];
		$req->toDate 			= $_SESSION['totDatum'];

		try {
			$result	= $client->ShowAvailableRooms($req);
			if(is_array($result->rooms->room)) {
				foreach ($result->rooms->room as $value) {
					$rooms[] = $value;
				}
			} else {
				$rooms[] = $result->rooms->room;
			}
		} catch(Exception $e) {
			echo '<div class="errormessage" id="notification">'.$e->detail->fault->message.'</div>';
			//$e->detail->fault->message.
		}
	}

	function calculatePrice($room) {
		//hotel.setFromPrice( (h.getRoomTypes().get(0).getPricePerNight() * ( (int)Math.ceil((double)numberOfPersons / (double)h.getRoomTypes().get(0).getNumberOfPersons()))  ) * calculateDays(fromDate, toDate)+"");
		$datetime1 = new DateTime($_SESSION['vanDatum']);
		$datetime2 = new DateTime($_SESSION['totDatum']);
		$days = $datetime1->diff($datetime2);
		return ($room->pricePerNight * ceil( (double)$_SESSION['aantalPersonen'] / (double)$room->numberOfPersons ) ) * $days->days;
	}
?>

<h1><?PHP echo $hotel != null ? $hotel->name : "" ?></h1>
<?PHP echo $hotel != null ? $hotel->description  : ""?>
<hr />
<table>
<?PHP foreach ($rooms as $room): ?>
	<tr>
		<td><h3><?PHP echo $room->name ?></h3></td>
	</tr>
	<tr>
		<td rowspan="3">
		<?PHP
		if(is_array($room->photos->photo)) {
			$photoUrl = $room->photos->photo[0]->url;
		} else {
			$photoUrl = $room->photos->photo->url;
		}
		?>
		<img src="<?PHP echo $photoUrl ?>" style="max-width: 150px; max-height: 150px;">
	</td>
	</tr>
	<tr>
		<td><?PHP echo strlen($room->description) > 350 ? substr($room->description, 0, 350).'...' : $room->description  ?></td>
	</tr>
	<tr>
		<td>
			<a class="button" href="index.php?page=boekHotel&hotel=<?PHP echo $hotel->ID ?>">Boeken</a>
			Vanaf: <?PHP echo calculatePrice($room) ?> Euro.
		</td>
	</tr>
<?PHP endforeach; ?>
</table>
</div>
<div class="clear"></div>