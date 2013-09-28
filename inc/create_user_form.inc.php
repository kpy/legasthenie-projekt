<?php

	// Create_User form s

	$connection = mysql_connect(DB_HOST, DB_USER , DB_PASS)
	or die("Verbindung zur Datenbank konnte nicht hergestellt werden");
	mysql_select_db(DB_NAME) or die ("Datenbank konnte nicht ausgewÃ¤hlt werden");
    
	// GET Variable erstellen, falls noch nicht gesetzt worden ist.
	if (!isset($_GET["ausgewaehlt"])) {
	    $_GET["ausgewaehlt"] = "";
	}
	
?>
<script type="text/javascript" src="./inc/javascript/function.inc.js"></script>
<form class="admin" action="./inc/create_user.inc.php" method="POST">
    <h1>Benutzer anlegen</h1>
    <fieldset id="auswahl">
    	<label>Typ: </label>
	    <input type="radio" name="typ" value="schueler" onclick="checkClickedUser();" <?php if($_GET["ausgewaehlt"] == "schueler") print "checked"?>><label> Schüler</label>
	    <input type="radio" name="typ" value="lehrer" onclick="checkClickedUser();" <?php if($_GET["ausgewaehlt"] == "lehrer") print "checked"?>><label> Lehrer</label>
	    <input type="radio" name="typ" value="admin" onclick="checkClickedUser();" <?php if($_GET["ausgewaehlt"] == "admin") print "checked"?>><label> Administrator</label>
    </fieldset>
<?php 
    if (($_GET["ausgewaehlt"] == "schueler") || ($_GET["ausgewaehlt"] == "lehrer") || ($_GET["ausgewaehlt"] == "admin")) {
?>
    <fieldset id="inputs">
    	<label>Name:</label>
        <input id="name" type="text" name="name" placeholder="Name" autofocus required>
    </fieldset>   
    <fieldset id="inputs">
    	<label>Vorname:</label>
        <input id="vorname" type="text" name="vorname" placeholder="Vorname" required>
    </fieldset>
<?php 
    }
?>
<?php 
    if ($_GET["ausgewaehlt"] == "lehrer" || $_GET["ausgewaehlt"] == "admin") {
?>
    <fieldset id="inputs">
        <label>Passwort:</label>
        <input id="password" type="password" name="password" placeholder="Passwort" required>
    </fieldset>
    <fieldset id="inputs">
        <label>Passwort wiederholen:</label>
        <input id="passwordConfirmation" type="password" name="passwordConfirmation" placeholder="Passwort wiederholen" required>
    </fieldset>
    <fieldset>
        <label>eMail:</label>
        <input id="eMail" type="email" name="eMail" placeholder="eMail" required>
    </fieldset>
    <fieldset id="">
    	<label>Rechte anpassen:</label>
    	<table border="1"><tr>
		<?php 
		/*
		 * Listet die Rechte in einer Tabelle auf. Rechte können über Checkboxen entzogen oder gesetzt werden.
		 * In jedem Feld befindet sich eine Checkbox. Nach jeder dritten Checkbox fängt eine neue Reihe an.
		 * Es stehen nur Checkboxen zur Auswahl, derene Rechte der momentane Benutzer besitzt.
		 */
			$query = "SELECT rightID, rightName FROM rights";			
			$result =  mysql_query($query) Or die("MySQL Fehler: " . mysql_error());	
			$neueZeile = 0;
			while($row = mysql_fetch_object($result)) {
			   		$neueZeile++;
			   		if ($neueZeile == 3) {
						print "<tr>";
					}		
			   		print "<td>";
			   		// Rechte des eingeloggten Benutzers mit den Checkboxen anpassen
			   		if(!is_null(hasRight($row->rightID, $_SESSION['rights']))) {
			   			print "<input type=\"checkbox\" name=\"rights\" value=\"$row->rightName\" checked>" . $row->rightName . "</input>";
			   		} else {
						print "<input type=\"checkbox\" name=\"rights\" value=\"$row->rightName\" disabled=\"disabled\">" . $row->rightName . "</input>";
					}
			   		print "</td>";
			   		if ($neueZeile == 3) {
			   			print "</tr>";
			   			$neueZeile = 0;
			   		}
			}
		?>
		</tr>
		</table>
    </fieldset>
<?php   	
    }
    if ($_GET["ausgewaehlt"] == "schueler") {    	
?>
    <fieldset id="inputs">
    	<label>Geburtsdatum:</label>
        <input id="geburtsdatum" type="date" name="geburtsdatum" placeholder="09.09.2002" required>
    </fieldset>   
    <fieldset id="inputs">
    	<label>Geschlecht:</label>
    	<select name="geschlecht">
          <option value="">Bitte auswählen</option>
          <option value="M">Männlich</option>
          <option value="F">Weiblich</option>
        </select>
    </fieldset>
    <fieldset id="inputs">
    	<label>Schule:</label>
        <input id="schule" type="text" name="schule" placeholder="Schule" required>
    </fieldset>
    <fieldset id="inputs">
    	<label>Klasse:</label>
        <input id="klasse" type="text" name="klasse" placeholder="3" required>
    </fieldset>
<?php 
    }   
?> 
    <fieldset id="actions">
        <input type="submit" id="submit" value="Anlegen">
    </fieldset>
</form>