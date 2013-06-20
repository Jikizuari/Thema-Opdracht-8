<div class="right" id="main-content-right">
	<div class="left" id="main-content-content">
		<h1><strong>Informatie </strong>vakantie</h1>
		<?php
			$holidayID = $_GET['id'];

			$client	= new SoapClient("http://tomcat.dkmedia.nl/tho8/userservice?wsdl");
			$output	= "";

			try {
				$output = $client->GetUserData(array('UserID'=>$_SESSION['user_id']));
				$DateOfBirth = $output->DateOfBirth;
				$DateOfBirth = str_replace("Z", "", $DateOfBirth);
			} catch(Exception $e) {
				require_once('essentials/usererror.php');
				$u = new userError();
				$errorMessage = $u->getErrorMessage($e->detail->fault->errorCode);
				echo '<div class="errormessage" id="notification">'.$errorMessage.'</div>';
			}
		?>
		<table id="tableStyle">
			<tr><td><span>Klantnummer</span> <?php echo $output->UserID ?></td><td><span>Woonplaats</span> <?php echo $output->City ?></td></tr>
			<tr><td><span>Voornaam</span> <?php echo $output->Name ?></td><td><span>Geboortedatum</span> <?php echo $DateOfBirth ?></td></tr>
			<tr><td><span>Achternaam</span> <?php echo $output->LastName ?></td><td><span>Telnummer</span> <?php echo $output->PhoneNumber ?></td></tr>
			<tr><td><span>Straat</span> <?php echo $output->Street ." ". $output->HouseNumber ?></td><td><span>E-mailadres</span> <?php echo $output->{'E-mail'} ?></td></tr>
			<tr><td><span>Postcode</span> <?php echo $output->ZipCode ?></td><td></td></tr>
		</table>
		<br/>
		<?php
			$holidayClient	= new SoapClient("http://tomcat.dkmedia.nl/tho8/userservice?wsdl");
			try {
				$result_hd = $holidayClient->GetHolidayData(array('HolidayID'=>$holidayID));
			} catch(Exception $e) {
				require_once('essentials/usererror.php');
				$u = new userError();
				$errorMessage = $u->getErrorMessage($e->detail->fault->errorCode);
				echo '<div class="errormessage" id="notification">'.$errorMessage.'</div>';
			}
			if($result_hd != "") {
		?>
		<table id="tableStyle">
			<tr><td><span>Ref.nummer</span> <?php echo $result_hd->HolidayID ?></td><td><span>Vertrekdatum</span> <?php echo str_replace("Z", "", $result_hd->DepartureDate) ?></td></tr>
			<tr><td><span>Totaalprijs</span> &euro; <?php echo number_format($result_hd->TotalPrice, 2, ',', '.') ?></td><td><span>Retourdatum</span> <?php echo str_replace("Z", "", $result_hd->ReturnDate) ?></td></tr>
		</table>
		<br/>
		<?php
			}
			foreach($result_hd->HolidayRecords as $hd_record) {
				if($hd_record->BookingComponent == "HotelID"){
					$hotelClient	= new SoapClient("http://tomcat.dkmedia.nl/hotelservice/hotelservice?wsdl");
					try {
					 	$result_hotel = $hotelClient->BookInfo(array('bookId'=>$hd_record->BookingIDFromComponent));
					} catch(Exception $e) {
					}
				}
				if($hd_record->BookingComponent == "TaxiID"){
					$vervoerClient	= new SoapClient("http://iis.dkmedia.nl/TO8.VervoerService.svc?wsdl");
					try {
					 	$result_vervoer = $vervoerClient->GetCarRental(array('id'=>$hd_record->BookingIDFromComponent));
					} catch(Exception $e) {
					}
				}
				if($hd_record->BookingComponent == "AttractionID"){
					// $attractieClient	= new SoapClient("http://iis.dkmedia.nl:85/WcfServiceLibrary1.Service1.svc?wsdl");
					// try {
					//  	$result_attr = $attractieClient->getBookingAttraction(array('booking'=>array('attraction_booking_idField'=>$hd_record->BookingIDFromComponent)));
					// } catch(Exception $e) {
					// }
					// echo $result_attr;
				}
			}
			if($result_hotel != "") {
		?>
		<table id="tableStyle">
			<tr><td><span>Naam hotel</span> <?php echo $result_hotel->hotel->name ?></td><td><span>Kamer</span> <?php echo $result_hotel->rooms->room->name ?></td></tr>
			<tr><td><span>Straat</span> <?php echo $result_hotel->hotel->street." ".$result_hotel->hotel->houseNr ?></td><td><span>Aant. personen</span> <?php echo $result_hotel->numberOfPersons ?></td></tr>
			<tr><td><span>Woonplaats</span> <?php echo $result_hotel->hotel->city ?></td><td><span>Totaalprijs</span> &euro; <?php echo number_format($result_hotel->price, 2, ',', '.') ?></td></tr>
		</table>
		<br/>
		<?php
			}
			if($result_vervoer != "") {
		?>
		<table id="tableStyle">
			<tr><td><span>Naam vervoer</span> <?php echo $result_vervoer->GetCarRentalResult->car->Name ?></td><td><span>Contactpersoon</span> <?php echo $result_vervoer->GetCarRentalResult->name ?></td></tr>
			<tr><td><span>Max. personen</span> <?php echo $result_vervoer->GetCarRentalResult->car->NumP ?></td><td><span>Totaalprijs</span> &euro; <?php echo number_format($result_vervoer->GetCarRentalResult->price, 2, ',', '.') ?></td></tr>
		</table>
		<br/>
		<?php
			}
		?>
		<a class="right button" href="?page=myholidays">Terug</a>
	</div>
	<?PHP require_once("essentials/sidebar.php"); ?>
</div>
<div class="clear"></div>
	