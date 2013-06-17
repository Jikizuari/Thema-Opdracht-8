<?php
	$stadInput				= $_GET['stad'];

	$client					= new SoapClient("http://tomcat.dkmedia.nl/geoservice/geoservice?wsdl");

	$addRequest 			= new stdClass();
	$addRequest->City 		= $stadInput;

	$output = array();

	try {
		$result		 			= $client->GetCoordinates($addRequest);
		
		$geo1	 				= $result->Geolocation->Longitude;
		$geo2	 				= $result->Geolocation->Latitude;

		$output['geo1'] 		= $geo1;
		$output['geo2'] 		= $geo2;
	} catch(Exception $e) {
		$output['error'] 	= $e->getMessage();
	}
	echo json_encode($output);
?>