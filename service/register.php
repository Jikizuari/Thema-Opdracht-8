<!doctype html>
<html>
<head>
	<script src="http://dkmedia.nl/saw/javascript/jquery-1.9.1.js"></script>
	<script>
	$(document).ready(function() {
		$("#stad").change(function() {
			document.getElementById('error').style.display = "none";
			document.getElementById('load').style.display = "inline";

			$('#error').text("");
			$('#geo1').val("");
			$('#geo2').val("");

			$.ajax({                                      
				url: 'WebserviceAPI.php',       
				data: "stad=" + $(this).val(), 							   		 							   		
				dataType: 'json',               		    
				success: function(data)          		
				{
					if(data['error'] != undefined) {
						document.getElementById('error').style.display = "block";
						$('#error').text(data['error']);

					} else {

						var geo1 = data['geo1'];
						var geo2 = data['geo2'];
						alert("Geo1: " + geo1 + ", Geo2: " + geo2);
						$('#geo1').val(geo1);
						$('#geo2').val(geo2);
					}
					document.getElementById('load').style.display = "none";
				} 
			});		
		});
	});


	</script>
	<style>
	body {
		background: #f0f0f0;
		font-family: Calibri;
	}
	hr {
		border: 0;
		height: 2px;
		background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
		background-image:    -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
		background-image:     -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
		background-image:      -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); 
	}
	h1 {
		font-size:22px;
		color: #1a1a1a;
		margin:0;
		padding:0;
	}
	.info {
		background: #eee;
		border: 1px solid #ccc;
		padding:5px;
		border-radius: 5px;
	}
	.errormessage {
		color: #bc0000;
		font-size: 14px;
		padding:5px;
		border:1px solid #bc0000;
		border-radius: 5px;
		background: #ecb5b5;
		text-align: center;
		display: none;
	}
	.right {
		float:right;
	}
	.content {
		background:white;
		width: 300px;
		margin: 0 auto;
		padding:20px;
		border-radius:10px;
		box-shadow: 0px 0px 5px #ccc;
		margin-top: 20px;
	}
	label {
		position: absolute;
	}
	input {
		margin-left: 146px;
		border-radius: 5px;
		border: 1px solid #ccc;
	}
	#load {
		margin-top:4px;
		position: absolute;
	}
	</style>
</head>
<body>
	<div class="content">
		<?php
		if(!isset($_POST['submit'])) {
			?>
			<h1>Register</h1>
			<hr/>
			<div class="errormessage" id="error"></div>

			<form name="registerForm" action="" method="post">

				<p>
					<label class="label">Name</label>
					<input type="text" id="name" name="name" />
				</p>
				<p>
					<label class="label">Last name</label>
					<input type="text" id="lname" name="lname" />
				</p>
				<p>
					<label class="label">Street</label>
					<input type="text" id="street" name="street" />
				</p>
				<p>
					<label class="label">Housenumber</label>
					<input type="text" id="housenmb" name="housenmb" />
				</p>
				<p>
					<label class="label">Zipcode</label>
					<input type="text" id="zip" name="zip" />
				</p>
				<p>
					<label class="label">City</label>
					<input type="text" id="addr" name="addr" />
				</p>
				<p>
					<label class="label">DateOfBirth</label>
					<input type="text" id="birth" name="birth" />
				</p>
				<p>
					<label class="label">Phone</label>
					<input type="text" id="phone" name="phone" />
				</p>
				<p>
					<label class="label">E-mail</label>
					<input type="text" id="mail" name="mail" />
				</p>
				<p>
					<label class="label">Password</label>
					<input type="text" id="pass" name="pass" />
				</p>
				<input type="submit" name="submit" value="submit" />
			</form>

			<?php
		} else {
			$name = $_POST['name'];
			$lname = $_POST['lname'];
			$street = $_POST['street'];
			$housenmb = $_POST['housenmb'];
			$zipcode = $_POST['zip'];
			$addr = $_POST['addr'];
			$birth = $_POST['birth'];
			$phone = $_POST['phone'];
			$email = $_POST['mail'];
			$pass = $_POST['pass'];

			$client						= new SoapClient("http://tomcat.dkmedia.nl/tho8/userservice?wsdl");

			$addRequest 				= new stdClass();
			$addRequest->Name 			= $name;
			$addRequest->Lastname		= $lname;
			$addRequest->Street 		= $street;
			$addRequest->HouseNumber 	= $housenmb;
			$addRequest->ZipCode 		= $zipcode;
			$addRequest->Address 		= $addr;
			$addRequest->DateOfBirth 	= $birth;
			$addRequest->PhoneNumber	= $phone;
			$addRequest->{'E-mail'}		= $email;
			$addRequest->Password 		= $pass;

			try {
				echo "Name: ".$name."<br/>";
				echo "Lastname: ".$lname."<br/>";
				echo "Street: ".$street."<br/>";
				echo "Housenbm: ".$housenmb."<br/>";
				echo "Zipcode: ".$zipcode."<br/>";
				echo "City: ".$addr."<br/>";
				echo "Date of birth: ".$birth."<br/>";
				echo "Phone: ".$phone."<br/>";
				echo "Email: ".$email."<br/>";
				echo "Password: ".$pass."<br/><br/>";

				$result	= $client->UserRegistration(array('Name'=>$name, 'Lastname'=>$lname, 'Street'=>$street, 'HouseNumber'=>$housenmb, 'ZipCode'=>$zipcode, 'City'=>$addr, 'DateOfBirth'=>$birth, 'PhoneNumber'=>$phone, 'E-mail'=>$email, 'Password'=>$pass));
				// $result	= $client->UserRegistration(array('Name'=>'Gijs', 'Lastname'=>'van Arem', 'Street'=>'Winterkersstraat', 'HouseNumber'=>'16', 'ZipCode'=>'3544CJ', 'City'=>'Utrecht', 'DateOfBirth'=>'1993-09-22', 'PhoneNumber'=>'0627447166', 'E-mail'=>'jikizuari@gmail.com', 'Password'=>'hoi123'));
				
				// $result = $client->GetUserData(array('UserID'=>11));
				// var_dump($result);
				

			} catch(Exception $e) {
				echo $e->detail->fault->message;
			}
		}
		?>
		<p style="display: none">
			<label>Password</label>
			<input disabled type="text" id="geo1" name="geo1" /><span id="load" style="display: none"><img src="http://dkmedia.nl/saw/images/loading.gif" alt="" /></span>
		</p>
	</div>
</body>
</html>