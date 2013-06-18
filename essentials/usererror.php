<?php
class userError
{
	public function getErrorMessage($errorCode) {
		switch ($errorCode) {
		case 1:
			return "Één of meer velden zijn leeg.";
			break;
		case 2:
			return "Onjuiste e-mailadres/wachtwoord combinatie.";
			break;
		case 3:
			return "Gebruiker bestaat niet.";
			break;
		case 4:
			return "E-mailadres is al in gebruik.";
			break;
		case 5:
			return "Geen gegevens gevonden voor de opgegeven gebruiker.";
			break;
		case 6:
			return "E-mailadres is al in gebruik door een andere gebruiker.";
			break;
		case 7:
			return "Geen gebruiker gevonden met het opgegeven userID.";
			break;
		case 8:
			return "Geen data gevonden.";
			break;
		case 9:
			return "Geen data aanwezig.";
			break;
		}
    }
}
?>

