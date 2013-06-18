<div class="right" id="main-content-right">
	<pre>
<?php
$attracties = array();
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

if(isset($_SESSION['stap3']) && $_SESSION['stap3']) {
	$_SESSION['stap4'] = true;
	if(isset($_GET['auto'])){
		$_SESSION['auto_id'] = $_GET['auto'];
	}
	$client	= new SoapClient("http://iis.dkmedia.nl:85/WcfServiceLibrary1.Service1.svc?wsdl");
	$req = new searchattraction();
	$req->searchattractions->holiday_end_dateField		= $_SESSION['totDatum'];
	$req->searchattractions->holiday_start_dateField		= $_SESSION['vanDatum'];
	$req->searchattractions->placeField	= $_SESSION['bestemming'];
	$req->searchattractions->reachField	= 50;

	try {
		$result	= $client->searchAttraction($req);
		var_dump($result);
	} catch(Exception $e) {
		echo "<pre>";
		echo $e;
		//echo '<div class="errormessage" id="notification">'.$e->detail->fault->message.'</div>';
	}
	
}
?>
<h1>Attracties Boeken</h1>
</div>
<div class="clear"></div>