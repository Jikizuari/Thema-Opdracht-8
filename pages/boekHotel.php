<div class="right" id="main-content-right">
	<div class="left" id="main-content-content">
		<h1><strong>Hotel</strong> boeken</h1>
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
			if($h->ID == $_SESSION['hotel_id']) {
				$hotel = $h;
				$_SESSION['hotel_name'] = $hotel->name;
				$_SESSION['hotel_city'] = $hotel->city;
			}
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
			<td style="padding-top:5px" valign="top" rowspan="3">
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
			<td style="padding-left:10px;"><?PHP echo strlen($room->description) > 350 ? substr($room->description, 0, 350).'...' : $room->description  ?></td>
		</tr>
		<tr>
			<td>
				<a class="right button" href="index.php?page=huurAuto&roomType=<?PHP echo $room->id ?>&numberOfRooms=<?PHP echo ceil( (double)$_SESSION['aantalPersonen'] / (double)$room->numberOfPersons ) ?>">Boeken</a>
				<span style="position:absolute; margin-top:17px;margin-left:150px;">Vanaf: <?PHP echo calculatePrice($room) ?> Euro</span>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<?PHP endforeach; ?>
	</table>
	<hr/>
	<a class="right button" href="index.php?page=cancel">Annuleer</a>
</div>
	<?php require_once('essentials/sidebar_boeken.php'); ?>
</div>
<div class="clear"></div>