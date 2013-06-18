<?php
	
	$userIDInput = $_GET['userid'];
	if($userIDInput == "" || $userIDInput == null) {
		$userIDInput = 1;
	}

	ini_set('display_errors',1); 
	error_reporting(E_ALL);

	$client	= new SoapClient("http://tomcat.dkmedia.nl/tho8/userservice?wsdl");
	$output	= "";

	try {
		//$output = $client->UserLogin(array('E-mail'=>'davey.kropf@gmail.com', 'Password'=>'hoi123'));
		//$output = $client->GetUserData(array('UserID'=>$userIDInput));
		$output	= $client->UserRegistration(array('Name'=>$name, 'Lastname'=>$lname, 'Street'=>$street, 'HouseNumber'=>$housenmb, 'ZipCode'=>$zipcode, 'City'=>$addr, 'DateOfBirth'=>$birth, 'PhoneNumber'=>$phone, 'E-mail'=>$email, 'Password'=>$pass));
	} catch(Exception $e) {
		$output = $e->detail->fault->message;
	}

	echo json_encode($output);
?>