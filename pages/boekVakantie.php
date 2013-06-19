<div class="right" id="main-content-right">
	<pre>
<?PHP 
$vlucht = 0;
$hotel 	= 0;
$car 	= 0;
$attr 	= 0;
$bookID = 0;

if( !(isset($_SESSION['stap5']) && $_SESSION['stap5']) ) {
	redirect("vakantie");
}
//boek vlucht
//######################################################################
$client	= new SoapClient("http://tomcat.dkmedia.nl/flightservice/flightservice?wsdl");

$req 						= new stdClass();
$req->departureAirport 		= $_SESSION['vertrekhaven'];
$req->arrivalAirport 		= $_SESSION['bestemming'];
$req->departureDate 		= $_SESSION['vanDatum'];
$req->arrivalDate 			= $_SESSION['totDatum'];
// var_dump($client->__getFunctions());
// var_dump($client->__getTypes());
try {
	//$result	= $client->searchFlight($req);
	//$result = $client->bookFlight();

} catch(Exception $e) { echo $e; }

//boek hotel/room
//######################################################################
class room {
	var $id;
	var $numberOfrooms;
}
class rooms {
	var $room;
}
class bookHotelRequest {
	var $hotelId;
	var $rooms;
	var $numberOfPersons;
	var $fromDate;
	var $toDate;

	function __construct() {
		$this->rooms = new rooms();
	}
}
$client	= new SoapClient("http://tomcat.dkmedia.nl/hotelservice/hotelservice?wsdl");
$req 					= new bookHotelRequest();
$req->hotelId 			= $_SESSION['hotel_id'];
$req->numberOfPersons 	= $_SESSION['aantalPersonen'];
$req->fromDate 			= $_SESSION['vanDatum'];
$req->toDate 			= $_SESSION['totDatum'];
$room					= new room();
$room->id 				= $_SESSION['hotel_roomType'];
$room->numberOfrooms	= $_SESSION['hotel_numberOfRooms'];
$req->rooms->room[]		= $room;

try {
	$result	= $client->BookHotel($req);
	if(isset($result->bookId))
		$hotel = $result->bookId;
} catch(Exception $e) {	echo $e; }

//boek car
//######################################################################
class rentCar {
	var $name;
	var $start;
	var $end;
	var $carid;
}
if(isset($_SESSION['auto_id'])) {
	$client	= new SoapClient("http://iis.dkmedia.nl/TO8.VervoerService.svc?wsdl");
	$req 		= new rentCar();
	$req->name 	= $_SESSION['user_name']." ".$_SESSION['user_lastname'];
	$req->start = $_SESSION['vanDatum'];
	$reg->end 	= $_SESSION['totDatum'];
	$reg->carid = $_SESSION['auto_id'];

	try {
		$result	= $client->RentCar($req);
		if(isset($result->RentCarResult))
			$car = $result->RentCarResult;
	} catch(Exception $e) {	echo $e; }
}

	//boek attractie
	//######################################################################
class attractionbookingreq{
	var $attractionidField ;
	var $number_of_personsField ;
	var $visit_dayField;
}
class bookAttraction {
	var $attractionbookingreq;
	function __construct() {
		$this->attractionbookingreq = new attractionbookingreq();
	}
}
if(isset($_SESSION['attr_id'])) {
	$client	= new SoapClient("http://iis.dkmedia.nl:85/WcfServiceLibrary1.Service1.svc?wsdl");
	$req = new bookAttraction();
	$req->attractionbookingreq->attractionidField = $_SESSION['attr_id'];
	$req->attractionbookingreq->number_of_personsField = $_SESSION['aantalPersonen'];
	$req->attractionbookingreq->visit_dayField = $_SESSION['vanDatum'];
	try {
		$result	= $client->bookAttraction($req);
		var_dump($result);
	} catch(Exception $e) {	echo $e; }
}

//boek vakantie
//######################################################################
class Flights {
	var $DepartureFlightID;
	var $ReturnFlightID;
}
class BookHolidayRequest {
	var $DepartureDate;
	var $ReturnDate;
	var $TotalPrice;
	var $Flights;
	var $HotelID;
	var $TaxiID;
	var $AttractionID;
	var $UserID;
	function __construct() {
		$this->Flights = new Flights();
		$this->AttractionID = array();
	}
}
$client	= new SoapClient("http://tomcat.dkmedia.nl/tho8/userservice?wsdl");
$req =  new BookHolidayRequest();
$req->DepartureDate 		= $_SESSION['vanDatum'];
$req->ReturnDate			= $_SESSION['totDatum'];
$req->TotalPrice			= $_SESSION['totalprice'];
$flights 					= new Flights();
$flights->DepartureFlightID = 1;
$flights->ReturnFlightID 	= 1;
$req->Flights 				= $flights;
$req->TaxiID				= $car;
$req->HotelID 				= $hotel;
$req->AttractionID[] 		= $attr;
$req->UserID 				= $_SESSION['user_id'];

try {
	$result	= $client->BookHoliday($req);
	if(isset($result->HolidayID))
		$bookID = $result->HolidayID;
} catch(Exception $e) {	echo $e; }    
?>	
<h1>Vakantie geboekt</h1>
<p>Uw vakantie is geboekt, een overzicht van uw vakanties kunt u <a href="index.php?page=myholidays">hier</a> vinden. </p>
<p>Uw vakantie boek ID is '<?PHP $bookID ?>'</p>
</div>
<div class="clear"></div>

<?PHP

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_lastname = $_SESSION['user_lastname'];

session_destroy();
session_start();

$_SESSION['user_id'] = $user_id;
$_SESSION['user_name'] = $user_name;
$_SESSION['user_lastname'] = $user_lastname;