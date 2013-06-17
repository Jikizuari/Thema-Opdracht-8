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
	<h1>Geoservice test</h1>
	<hr/>
	<p class="info">
		Voer hieronder een stad in en druk op tab. Magic will happen. <img class="right" src="http://www.darkspyro.net/skylanders/icon_hat_wizard.png" alt="" />
	</p>
	<div class="errormessage" id="error"></div>
	<p>
	<label class="label">Stad</label>
		<input type="text" id="stad" name="stad" />
	</p>
	<p>
	<label>Geo1</label>
		<input disabled type="text" id="geo1" name="geo1"/><span id="load" style="display: none"><img src="http://dkmedia.nl/saw/images/loading.gif" alt="" /></span>
	</p>
	<p>
	<label>Geo2</label>
		<input disabled type="text" id="geo2" name="geo2"/>
	</p>
</div>
</body>
</html>