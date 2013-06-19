<div class="right" id="main-content-right">
	
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
	$req->searchattractions->reachField	= 10000;
	try {
		$result	= $client->searchAttraction($req);
		if(isset($result->searchAttractionResult->attraction)) {
			if(is_array($result->searchAttractionResult->attraction)) {
				foreach ($result->searchAttractionResult->attraction as $value) {
					$attracties[] = $value;
				}
			} else {
				$attracties[] = $result->searchAttractionResult->attraction;
			}
		}
		if(empty($attracties))
			redirect("boekOverzicht");

	} catch(Exception $e) {
		echo '<div class="errormessage" id="notification">'.$e->detail->fault->message.'</div>';
	}
	
} else {
	redirect("huurAuto");
}
?>
<h1>Attracties Boeken</h1>
<table>
<?PHP foreach ($attracties as $attr): ?>
	<tr>
		<td rowspan="6"><pre>
			<?PHP if(isset($attr->attractionphotosField->attractionphoto) && is_array($attr->attractionphotosField->attractionphoto)){
				$photoUrl = $attr->attractionphotosField->attractionphoto[0]->urlField;
			} elseif(isset($attr->attractionphotosField->attractionphoto->urlField)) {
				$photoUrl = $attr->attractionphotosField->attractionphoto->urlField;
			} ?>
			<img src="<?PHP echo $photoUrl ?>" style="max-width: 150px; max-height: 150px; padding: 5px;">
		</td>
	</tr>
	<tr>
		<td collspan="2"><h3><?PHP echo $attr->nameField ?></h3></td>
	</tr>
	<tr>
		<td>Straat</td>
		<td><?PHP echo $attr->streetField.' '.$attr->housenumberField  ?></td>
	</tr>
	<tr>
		<td>Adres</td>
		<td><?PHP echo $attr->postalField.' '.$attr->cityField  ?></td>
	</tr>
	<tr>
		<td>Info</td>
		<td><?PHP echo $attr->informationField  ?></td>
	</tr>
	<tr>
		<td>
			<a class="button" href="index.php?page=boekOverzicht&attr=<?PHP echo $attr->idField ?>">Kaarten kopen</a>
		</td>
	</tr>
	<tr><td>&nbsp;&nbsp;</tr>
<?PHP endforeach; ?>
</table>
<hr />
<a class="button" href="index.php?page=cancel">Annuleer</a> <a class="button" href="index.php?page=boekOverzicht">Overslaan</a>
</div>
<div class="clear"></div>