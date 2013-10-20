<?php
	
	/* create_user.inc.php */

	session_start();
	include "function.inc.php";
	
	// Allgemeines Recht "Benutzer anlegen" prüfen
	if(is_null(hasRight(CREATE_USER, $_SESSION['rights']))) {
		header( 'Location: index.php' ) ;
	}
	
	// Verbindung zur Datenbank
	$connection=mysqli_connect(DB_HOST, DB_USER , DB_PASS, DB_NAME);

	// Verbindung überprüfen
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
		
	echo "<h2>Benutzer anlegen</h2>";
	
	/*
	 * Je nach Usertyp, fülle die Variable $sql mit dem entsprechend angepassten
	 * SQL Befehl. Werte werden aus der $_POST Variable übernommen. 
	 */
	if ($_POST["typ"] == "schueler") {
		// SQL Statement vorbereiten
		$sql="INSERT INTO schueler (name, vorname, geburtsdatum, geschlecht, schule, klasse)
		VALUES('$_POST[name]','$_POST[vorname]','$_POST[geburtsdatum]', '$_POST[geschlecht]','$_POST[schule]', '$_POST[klasse]')";		
	} 
	if ($_POST["typ"] == "lehrer" || $_POST["typ"] == "admin") {
		// Generiere Salt und mit Hilfe des Passworts -> den Hash	
		$salt = blowfishSalt();
		$hash = crypt($_POST['password'],$salt);
	} 
	if ($_POST["typ"] == "admin") {	
		// SQL Statement vorbereiten
		$sql="INSERT INTO accounts (name, firstname, Username, Password_Salt, Password_Hash)
		VALUES('$_POST[name]','$_POST[vorname]','$_POST[username]', '$salt','$hash')";
	} 
	if ($_POST["typ"] == "lehrer") {
		// SQL Statement vorbereiten
		$sql="INSERT INTO accounts (name, firstname, Username, Password_Salt, Password_Hash)
		VALUES('$_POST[name]','$_POST[vorname]','$_POST[username]', '$salt','$hash')";
	} 
	
	// SQL Befehl($sql) ausführen bzw. neuen User in die Tabelle "accounts" eintragen
	if (!mysqli_query($connection,$sql)) {
		die('Error: ' . mysqli_error($connection));
	}
	echo "Eintrag erfolgreich durchgeführt.";
		
	/*
	 * Lehrer und Admins benötigen einen weiteren Eintrag in der Tabelle "account_roles".
	 * Diese teilt dem User seine Rechte zu. Dies kann erst nach dem Eintrag in der 
	 * Tabelle "accounts" geschehen, da wir erst dann die benötigte AccountID erhalten.
	 * Hierbei werden accountID und rightID(1=Admin 2=Lehrer) verknüpft. Spezielle Berechtigungen werden
	 * mit der Tabelle "account_rights_adjust" geregelt.
	 */
	if ($_POST["typ"] == "admin") {
		$rightID = "1";
	} elseif ($_POST["typ"] == "lehrer") {
		$rightID = "2";
	}
	if ($_POST["typ"] == "lehrer" || $_POST['typ'] == "admin") {
		// Gerade erstellte accountID(Primärschlüssel in "accounts") holen.
		$AccountID = "SELECT ID FROM accounts WHERE Password_Hash='$hash'";
		$result = mysqli_query($connection,$AccountID);
		$row = mysqli_fetch_array($result);
		$benutzerID = $row[0];
		// accountID mit rightID SQL Statement vorbereiten und ausführen.
		$sql = "INSERT INTO account_roles(accountID, roleID) VALUES('$row[0]', '$rightID')";
		mysqli_query($connection, $sql);
		// Spezielle Berechtigungen in der Tabelle "account_rights_adjust" anpassen
		$rechte_post = $_POST["rights"];
		$getListe = "Select * FROM rights";
		$result = mysqli_query($connection, $getListe);
		while ($row = $result->fetch_assoc()) {
			if (!(array_search($row["rightName"], $rechte_post) !== FALSE)) {
				setAdjustment($benutzerID, $row['rightID'], -1);
			}
		}
	} 
	
	// Verbindung schließen
	mysqli_close($connection);
	
?>