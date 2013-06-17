	<footer>
		<ul>
			<li>
				<h1>Algemeen</h1>
				<ul>
					<li><a href="#">Over Distant Pleasure</a></li>
					<li><a href="#">Veelgestelde vragen</a></li>
					<li><a href="#">Voorwaarden</a></li>
					<li><a href="#">Disclaimer</a></li>
				</ul>
			</li>
			<li>
				<h1>Service</h1>
				<ul>
					<li><a href="#">Stel een reis samen</a></li>
					<li><a href="#">Beoordelingen</a></li>
					<li><a href="#">Privacy</a></li>
				</ul>
			</li>
			<li>
				<h1>Aanbiedingen</h1>
				<ul>
					<li><a href="#"><span>&euro;250,- p.p.</span> Barcelona</a></li>
					<li><a href="#"><span>&euro;550,- p.p.</span> Antarctica</a></li>
					<li><a href="#"><span>&euro;175,- p.p.</span> Berlijn</a></li>
					<li><a href="#"><span>&euro;775,- p.p.</span> Zuid-Afrika</a></li>
				</ul>
			</li>
			<li>
				<h1>Onze partners</h1>
				<ul>
					<li><a href="#">D-Reizen</a></li>
					<li><a href="#">Arke.nl</a></li>
					<li><a href="#">Globe Reisburo</a></li>
				</ul>
			</li>
			<li>
				<h1>Contact</h1>
				<ul>
					<li class="last"><img src="img/icons/phone.png" alt="" />0900-1881 (elke dag tot 22:00 / 15 c.p.m.)</li>
					<li class="last"><img src="img/icons/envelope.png" alt="" /><a href="#">online@contact.distantpleasure.nl</a></li>
					<li class="last"><img src="img/icons/globe.png" alt="" />Kom langs in een van onze 250 Vakantiewinkels.</li>
				</ul>
			</li>
		</ul>
		<div class="clear"></div>
	</footer>
</section>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="js/slides.min.jquery.js"></script>
<script type="text/javascript" src="js/jquery.selectbox-0.2.min.js"></script>
<script type="text/javascript">

$(function() {
	$( "#datepicker" ).datepicker({
		dateFormat : 		'dd-mm-yy',
		showAnim: 			'fade',
		minDate: 			new Date(),
		changeYear: 		false,
		monthNames: 		['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni','Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
		monthNamesShort: 	['jan', 'feb', 'maa', 'apr', 'mei', 'jun','jul', 'aug', 'sep', 'okt', 'nov', 'dec'],
		dayNames: 			['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
		dayNamesShort: 		['Zon', 'Maan', 'Din', 'Woe', 'Don', 'Vri', 'Zat'],
		dayNamesMin: 		['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
		prevText: 			'Vorige maand', 
		nextText: 			'Volgende maand',
		defaultStatus: 		'Kies een datum',
	});
});
$(function(){
	$('#slides').slides({
		preload: true,
		preloadImage: 'img/loading.gif',
		play: 10000,
		pause: 2500,
		hoverPause: true,
	});
});
	//Selectbox styling
	$(function () {
		$("#select").selectbox();
	});
	</script>
</body>

</html>