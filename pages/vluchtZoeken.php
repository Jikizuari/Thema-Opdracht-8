<div class="right" id="main-content-right">
	<div class="left" id="main-content-content">
		<h1><strong>Stel</strong> uw vakantie samen - <strong>Vlucht boeken</strong></h1>
		<?PHP
		$flights = array();

		if(isset($_POST['submit'])){
			$_SESSION['vertrekhaven'] 		= ucfirst($_POST['vertrekhaven']);
			$_SESSION['bestemming'] 		= ucfirst($_POST['bestemming']);
			$_SESSION['vanDatum'] 			= $_POST['vertrekDatum'];
			$_SESSION['totDatum'] 			= $_POST['aankomstDatum'];
			$_SESSION['aantalPersonen']		= $_POST['aantalPersonen'];
			$_SESSION['formValid'] 			= true;


			if($_SESSION['vertrekhaven'] == "") {
				echo '<div class="errormessage" id="notification">Vul een vertrekhaven in.</div>';
				$_SESSION['formValid'] = false;
			} else if($_SESSION['bestemming'] == "") {
				echo '<div class="errormessage" id="notification">Vul een bestemming in.</div>';
				$_SESSION['formValid'] = false;
			} else if($_SESSION['aantalPersonen'] == "" || !is_numeric($_SESSION['aantalPersonen'])) {
				echo '<div class="errormessage" id="notification">Vul een aantal personen in.</div>';
				$_SESSION['formValid'] = false;
			} else if($_SESSION['vanDatum'] == "") {
				echo '<div class="errormessage" id="notification">Vul een vertrekdatum in.</div>';
				$_SESSION['formValid'] = false;
			} else if($_SESSION['totDatum'] == "") {
				echo '<div class="errormessage" id="notification">Vul een aankomstdatum in.</div>';
				$_SESSION['formValid'] = false;
			}


		}
		if(isset($_SESSION['formValid']) && $_SESSION['formValid']) {
			$client	= new SoapClient("http://env-9681936.jelastichosting.nl/fs/services/flightservice?wsdl");

			$req 			= new stdClass();
			$req->arg0 		= $_SESSION['vertrekhaven'];
			$req->arg1 		= $_SESSION['bestemming'];
			$req->arg2		= date("d-m-y H:i:s", strtotime($_SESSION['vanDatum']));
			$req->arg3		= date("d-m-y H:i:s", strtotime($_SESSION['totDatum']));

			try {
				$result	= $client->searchFlight($req);
				if(is_array($result->return)) {
					foreach ($result->return as $vlucht) {
						$flights[] = $vlucht;
					}
				} else {
					$flights[] = $result->return;
				}
			} catch(Exception $e) {
				echo '<div class="errormessage" id="notification">'.$e->detail->fault->message.'</div>';
			}
		}
		?>

		<form id="registerForm" name="vluchtForm" method="post">
			<label>Vertrekhaven</label>	
			<span>Van waar wilt u vertrekken?</span>
			<input name="vertrekhaven" type="text" value="<?php if(isset($_SESSION['vertrekhaven'])) { echo $_SESSION['vertrekhaven']; } else { echo ""; } ?>"/>

			<label>Bestemming</label>
			<span>Waar wilt u heen?</span>
			<input name="bestemming"  type="text" value="<?php if(isset($_SESSION['bestemming'])) { echo $_SESSION['bestemming']; } else { echo ""; } ?>"/>

			<label>Vertrekdatum</label> 
			<span>Wanneer wilt u vertrekken?</span>
			<input style="padding-left:25px; width:235px;" name="vertrekDatum" class="datepicker" type="text" value="<?php if(isset($_SESSION['vanDatum'])) { echo $_SESSION['vanDatum']; } else { echo ""; } ?>"/>

			<label>Retourdatum</label> 
			<span>Wanneer wilt u terug?</span>
			<input style="padding-left:25px; width:235px;" name="aankomstDatum" class="datepicker" type="text" value="<?php if(isset($_SESSION['totDatum'])) { echo $_SESSION['totDatum']; } else { echo ""; } ?>"/>

			<label>Aantal personen</label> 
			<span>Met hoeveel personen wilt u gaan?</span>
			<input name="aantalPersonen" type="text" value="<?php if(isset($_SESSION['aantalPersonen'])) { echo $_SESSION['aantalPersonen']; } else { echo ""; } ?>"/>

			<a class="right button" href="index.php?page=cancel">Annuleer</a>
			<button class="right button" type="submit" name="submit" >Zoeken</button>
		</form>
		<p>
			<?PHP if(isset($_SESSION['formValid']) && $_SESSION['formValid']) { ?>
			<h1><strong>Gevonden</strong> vluchten (<?PHP echo count($flights); ?>)</h1>
			<?PHP } ?>
			<table id="tableStyle">
				<?PHP foreach ($flights as $flight): ?>
				<tr>
					<td><span>Vluchtcode:</span> <?PHP echo $flight->flightCode ?></td>
					<td><span>Maatschappij:</span> <?PHP echo $flight->airline ?></td>
				</tr>
				<tr>
					<td><span>Vertrekhaven:</span> <?PHP echo $flight->departureAirport->name ?></td>
					<td><span>Bestemming:</span> <?PHP echo $flight->arrivalAirport->name ?></td>
				</tr>
				<tr>
					<td><span>Vertrek:</span> <?PHP $toReplace = array("T", "Z"); echo str_replace($toReplace, " ", $flight->departureDate) ?></td>
					<td><span>Aankomst:</span> <?PHP echo str_replace($toReplace, " ", $flight->arrivalDate) ?></td>
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