<?php
	
	/* create_user.inc.php */

	session_start();
	include "function.inc.php";
	
	// Verbindung zur Datenbank
	$connection=mysqli_connect(DB_HOST, DB_USER , DB_PASS, DB_NAME);
	// Verbindung �berpr�fen
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
		
	echo "<h2>Benutzer anlegen</h2>";
	
	if(is_null(hasRight(CREATE_USER, $_SESSION['rights']))) {
	    header( 'Location: ../index.php' ) ;
	}
	
	/*
	 * Je nach Usertyp, f�lle die Variable $sql mit dem entsprechend angepassten
	 * SQL Befehl. Werte werden aus der $_POST Variable �bernommen.
	 */
	if ($_POST["typ"] == "schueler") {
		// SQL Statement vorbereiten
		$sql="INSERT INTO schueler (name, vorname, geburtsdatum, geschlecht, schule, klasse)
		VALUES('$_POST[name]','$_POST[vorname]','$_POST[geburtsdatum]', '$_POST[geschlecht]','$_POST[schule]', '$_POST[klasse]')";		
	} elseif ($_POST["typ"] == "lehrer") {
		// Generiere Salt und mit Hilfe des Passworts den Hash	
		$salt = blowfishSalt();
		$hash = crypt($_POST['password'],$salt);
		
		// SQL Statement vorbereiten
		$sql="INSERT INTO accounts (name, firstname, eMail, Password_Salt, Password_Hash)
		VALUES('$_POST[name]','$_POST[vorname]','$_POST[eMail]', '$salt','$hash')";
		
	} elseif ($_POST["typ"] == "admin") {
		// Generiere Salt und mit Hilfe des Passworts den Hash
		$salt = blowfishSalt();
		$hash = crypt($_POST['password'],$salt);
		
		// SQL Statement vorbereiten
		$sql="INSERT INTO accounts (name, firstname, eMail, Password_Salt, Password_Hash)
		VALUES('$_POST[name]','$_POST[vorname]','$_POST[eMail]', '$salt','$hash')";
	}
	
	// SQL Befehl($sql) ausf�hren bzw. neuen User in die Tabelle "accounts" eintragen
	if (!mysqli_query($connection,$sql)) {
		die('Error: ' . mysqli_error($connection));
	}
	echo "Eintrag erfolgreich durchgef�hrt.";
		
	/*
	 * Lehrer und Admins ben�tigen einen weiteren Eintrag in der Tabelle "account_roles".
	 * Diese teilt dem User seine Rechte zu. Dies kann erst nach dem Eintrag in der 
	 * Tabelle "accounts" geschehen, da wir erst dann die ben�tigte AccountID erhalten.
	 * Hierbei werden accountID und rightID(1=Admin 2=Lehrer) verkn�pft.
	 */
	if ($_POST["typ"] == "admin") {
		$rightID = "1";
	} elseif ($_POST["typ"] == "lehrer") {
		$rightID = "2";
	}
	if ($_POST["typ"] == "lehrer" || $_POST['typ'] == "admin") {
		// Gerade erstellte accountID(Prim�rschl�ssel in "accounts") holen.
		$AccountID = "SELECT ID FROM accounts WHERE Password_Hash='$hash'";
		$result = mysqli_query($connection,$AccountID);
		$row = mysqli_fetch_array($result);
		// accountID mit rightID SQL Statement vorbereiten und ausf�hren.
		$sql = "INSERT INTO account_roles(accountID, roleID) VALUES('$row[0]', '$rightID')";
		mysqli_query($connection, $sql);
	} 
	
	// Verbindung schlie�en
	mysqli_close($connection);
	
?>