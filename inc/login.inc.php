 <?php
 	/* login.inc.php */
 	
 	// Im Live-System entfernen
 	error_reporting(E_ALL);

 	// Benötigte Dateien einbinden
	include "function.inc.php";
	session_start();

	// Verbindung zur Datenbank aufbauen
	$connection = mysql_connect(DB_HOST, DB_USER , DB_PASS)
	or die("Verbindung zur Datenbank konnte nicht hergestellt werden");
	mysql_select_db(DB_NAME) or die ("Datenbank konnte nicht ausgewählt werden");
	
	// Abfrage des übergeben Namens auf der Datenbank
	// Test auf SQL-Injektion fehlt noch
	$email = $_POST["email"];
	$query = "SELECT ID, eMail, Password_Salt, Password_Hash FROM accounts WHERE eMail LIKE '$email' LIMIT 1";
	$result = mysql_query($query);
	$row = mysql_fetch_object($result);
	$passwordHash = crypt($_POST["password"], $row->Password_Salt);

	// Vergleiche Passwort-Hashes
	if($row->Password_Hash === $passwordHash) {
	    $_SESSION["email"] = $email;
	    $rights = getRightsWithName($row->ID);
	    $_SESSION["rights"] = $rights;
	    header( 'Location: ../index.php' ) ;
	} else {
	    echo "Benutzername und/oder Passwort waren falsch. <a href=\"../index.php\">Login</a>";
	}
	
?> 