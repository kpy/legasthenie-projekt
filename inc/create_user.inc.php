<?php
	
	/* create_user.inc.php */

	session_start();
	include "function.inc.php";
	
	echo "<h2>Benutzer anlegen</h2>";
	
	if(is_null(hasRight(CREATE_USER, $_SESSION['rights']))) {
	    header( 'Location: ../index.php' ) ;
	}
	
	if ($_POST["typ"] == "schueler")
	{
		echo "Es handelt sich um einen Schüler<br>";
		echo "Name: " . $_POST['name'] . "<br>";
		echo "Vorname: " . $_POST['vorname'] . "<br>";
		echo "Geburtsdatum: " . $_POST['geburtsdatum'] . "<br>";
		echo "Geschlecht: " . $_POST['geschlecht'] . "<br>";
		echo "Schule: " . $_POST['schule'] . "<br>";
		echo "Klasse: " . $_POST['klasse'] . "<br>";
	}
	if ($_POST["typ"] == "lehrer")
	{
		echo "Es handelt sich um einen Lehrer<br>";
		echo "Name: " . $_POST['name'] . "<br>";
		echo "Vorname: " . $_POST['vorname'] . "<br>";
		echo "Paswort: " . $_POST['password'] . "<br>";
		echo "Passwort wiederholen: " . $_POST['passwordConfirmation'] . "<br>";
		echo "eMail: " . $_POST['eMail'] . "<br>";
		echo "Rechte: " . $_POST['rights'] . "<br>";
	}
	if ($_POST["typ"] == "admin")
	{
		echo "Es handelt sich um einen Administrator<br>";
		echo "Name: " . $_POST['name'] . "<br>";
		echo "Vorname: " . $_POST['vorname'] . "<br>";
		echo "Paswort: " . $_POST['password'] . "<br>";
		echo "Passwort wiederholen: " . $_POST['passwordConfirmation'] . "<br>";
		echo "eMail: " . $_POST['eMail'] . "<br>";
		echo "Rechte: " . $_POST['rights'] . "<br>";
	}
	
	
?>