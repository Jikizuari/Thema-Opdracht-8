<div class="right" id="main-content-right">
<?PHP 
if(isset($_SESSION['stap4']) && $_SESSION['stap4']){
	$_SESSION['stap5'] = true;
	if(isset($_GET['attr']))
		$_SESSION['attr_id'] = $_GET['attr'];
}

if(!isset($_SESSION['user_id'])){
	redirect('login');
}

$vlucht = null;
$room = null;
$car = null;
$attr = null;

if(isset($_SESSION['stap5']) && $_SESSION['stap5']) {
	$client	= new SoapClient("http://env-9681936.jelastichosting.nl/fs/services/flightservice?wsdl");

	$req 						= new stdClass();
	$req->arg0 		= $_SESSION['vertrekhaven'];
	$req->arg1 		= $_SESSION['bestemming'];
	$req->arg2		= date("d-m-y H:i:s", strtotime($_SESSION['vanDatum']));
	$req->arg3		= date("d-m-y H:i:s", strtotime($_SESSION['totDatum']));

	try {
		$result	= $client->searchFlight($req);
		if(is_array($result->return)) {
			foreach ($result->return as $v) {
				if($v->flightId == $_SESSION['vlucht_id'])
					$vlucht = $v; 
			}
		} else {
			if($result->return->flightId == $_SESSION['vlucht_id'])
					$vlucht = $result->return; 
		}
	} catch(Exception $e) {
		//echo '<div class="errormessage" id="notification">'.$e->detail->fault->message.'</div>';
		echo $e;
	}

	//get hotel/room
	$client	= new SoapClient("http://tomcat.dkmedia.nl/hotelservice/hotelservice?wsdl");
	$req 					= new stdClass();
	$req->hotelId 			= $_SESSION['hotel_id'];
	$req->numberOfPersons 	= $_SESSION['aantalPersonen'];
	$req->fromDate 			= $_SESSION['vanDatum'];
	$req->toDate 			= $_SESSION['totDatum'];

	try {
		$result	= $client->ShowAvailableRooms($req);
		if(is_array($result->rooms->room)) {
			foreach ($result->rooms->room as $r) {
				if($r->id == $_SESSION['hotel_roomType'])
					$room = $r;
			}
		} else {
			if($result->rooms->room->id == $_SESSION['hotel_roomType'])
					$room = $result->rooms->room;
		}
	} catch(Exception $e) {
		//echo '<div class="errormessage" id="notification">'.$e->detail->fault->message.'</div>';
		echo $e;
	}

	//get car
	$client	= new SoapClient("http://iis.dkmedia.nl/TO8.VervoerService.svc?wsdl");
	$req 					= new stdClass();
	$req->numP 	= $_SESSION['aantalPersonen'];

	try {
		$result	= $client->GetAvailableCars($req);
		if(isset($result->GetAvailableCarsResult->Car)) {
			if(is_array($result->GetAvailableCarsResult->Car)) {
				foreach ($result->GetAvailableCarsResult->Car as $value) {
					if($value->carId == $_SESSION['auto_id'])
						$car = $value;
				}
			} else {
				if($result->GetAvailableCarsResult->Car == $_SESSION['auto_id'])
					$car = $result->GetAvailableCarsResult->Car;
			}
		}
	} catch(Exception $e) {
		//echo '<div class="errormessage" id="notification">'.$e->detail->fault->message.'</div>';
		echo $e;
	}

	//get attractie
	class searchattractions{
		var $holiday_end_dateField;
		var $holiday_start_dateField;
		var $placeField;
		var $reachField;
	}
	class searchattraction {
		var $searchattractions;
		function __construct() {
			$this->searchattractions = new searchattractions();
		}
	}
	$client	= new SoapClient("http://iis.dkmedia.nl:85/WcfServiceLibrary1.Service1.svc?wsdl");
	$req = new searchattraction();
	$req->searchattractions->holiday_end_dateField		= $_SESSION['totDatum'];
	$req->searchattractions->holiday_start_dateField		= $_SESSION['vanDatum'];
	$req->searchattractions->placeField	= $_SESSION['bestemming'];
	$req->searchattractions->reachField	= 50;
	try {
		$result	= $client->searchAttraction($req);
		if(isset($result->searchAttractionResult->attraction)) {
			if(is_array($result->searchAttractionResult->attraction)) {
				foreach ($result->searchAttractionResult->attraction as $value) {
					$attracties[] = $value;
					if($value->idField == $_SESSION['attr_id'] )
						$attr = $value;
				}
			} else {
				if($result->searchAttractionResult->attraction->idField == $_SESSION['attr_id'] )
						$attr = $result->searchAttractionResult->attraction;
			}
		}
	} catch(Exception $e) {
		//echo '<div class="errormessage" id="notification">'.$e->detail->fault->message.'</div>';
		echo $e;
	}


} else {
	redirect("vakantie");
}
?>	
<h1>Boek Vakantie</h1>
<pre>
<?PHP
var_dump($vlucht);
var_dump($room);
var_dump($car);
var_dump($attr);
?>
</pre>
</div>
<div class="clear"></div>