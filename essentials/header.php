<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Distant Pleasure</title>
	<link href="css/style.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/south-street/jquery-ui.css" type="text/css" />


	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Droid+Serif' rel='stylesheet' type='text/css'>
	

</head>
<body>
	<header>
		<section id="top">
			<div class="content">
				<?PHP if(!isset($_SESSION['user_id'])): ?>
				<a class="right button" href="?page=login">Inloggen</a>
				<a class="right button" href="?page=register">Registreren</a>
				<?PHP else: ?>
					Welkom, <a href=""><?PHP echo $_SESSION['user_name']." ".$_SESSION['user_lastname'] ?></a>
				<?PHP endif; ?>
			</div>
		</section>
		<section id="top-overlay"></section>
		<section class="content">
			<a href="?page=index"><img id="logo" src="img/logo.png" alt="" /></a>
		</section>
		<section id="above" class="content">
		</section>
	</header>
	<section class="content"  id="slider">
		<div id="slides">
			<div class="slides_container">
				<div class="slide">
					<img src="img/slider1.png" alt="Slide 1">
					<div class="caption">
						<p><h1>Op vakantie?</h1>
							Stel nu uw eigen reis binnen 5 minuten samen!<br/>
							<a class="sliderbutton" href="#">Begin hier &raquo;</a>
						</p>
					</div>
				</div>
				<div class="slide">
					<img src="img/slider2.png" alt="Slide 1">
					<div class="caption">
						<p><h1>Op vakantie?</h1>
							Stel nu uw eigen reis binnen 5 minuten samen!<br/>
							<a class="sliderbutton" href="#">Begin hier &raquo;</a>
						</p>
					</div>
				</div>	
			</div>
			<a href="#" class="prev"><img src="img/prev.png" alt="Arrow Prev"></a>
			<a href="#" class="next"><img src="img/next.png" alt="Arrow Next"></a>
		</div>
	</section>
	<section id="main-content" class="content">
		<div class="left" id="main-content-left">
			<nav  id="sidemenu">
				<ul>
					<a href="#"><li><img src="img/icons/plane.png" alt="" />Reizen</li></a>
					<a href="#"><li><img src="img/icons/suitcase.png" alt="" />Aanbiedingen</li></a>
					<a href="#"><li><img src="img/icons/boat.png" alt="" />Over ons</li></a>
					<a href="#"><li><img src="img/icons/signpost.png" alt="" />Contact</li></a>
					<li></li>
				</ul>
			</nav>
		</div>