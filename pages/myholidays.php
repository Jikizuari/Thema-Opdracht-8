<div class="right" id="main-content-right">
	<div class="left" id="main-content-content">
		<h1><strong>Mijn </strong>boekingen</h1>
		<?php
			$client	= new SoapClient("http://tomcat.dkmedia.nl/tho8/userservice?wsdl");
			$output	= "";

			try {
				$output = $client->GetAllBookedHolidays(array('UserID'=>$_SESSION['user_id']));
			} catch(Exception $e) {
				require_once('essentials/usererror.php');
				$u = new userError();
				$errorMessage = $u->getErrorMessage($e->detail->fault->errorCode);
				echo '<div class="errormessage" id="notification">'.$errorMessage.'</div>';
			}

			if($output != ""){
				$counter = 1;
				echo '<table id="tableStyle"><tr><td width="10px"><b>Nr</b></td><td><b>Bestemming</b></td><td><b>Vertrekdatum</b></td><td><b>Terugkomst</b></td><td><b>Totaalprijs</b></td><td><b>Info</b></td></tr>';
				foreach ($output->Holiday as $holiday) {
					foreach ($holiday->HolidayRecords as $record) {
					 	if($record->BookingComponent == "HotelID"){
					 		$hotelID = $record->BookingIDFromComponent;
					 	}
					}
					$hotelClient	= new SoapClient("http://tomcat.dkmedia.nl/hotelservice/hotelservice?wsdl");
					try {
					 	$result = $hotelClient->BookInfo(array('bookId'=>$hotelID));
					 	$location = $result->hotel->city;
					} catch(Exception $e) {
					 	$location = "Onbekend";
					}
					echo '<tr><td>#'.$counter.'</td><td>'.$location.'</td><td>'.str_replace("Z", "", $holiday->DepartureDate).'</td><td>'.str_replace("Z", "", $holiday->ReturnDate).'</td><td>&euro; '.number_format($holiday->TotalPrice, 2, ',', '.').'</td><td><a href="?page=holidayinfo&amp;id='.$holiday->HolidayID.'"><img src="img/icons/info.png" alt="i" /></a></td></tr>';
					$counter++;
				}
				echo '</table>';
			}
		?>
		<a class="right button" href="?page=myaccount">Terug</a>
	</div>
	<?PHP require_once("essentials/sidebar.php"); ?>
</div>
<div class="clear"></div>
	