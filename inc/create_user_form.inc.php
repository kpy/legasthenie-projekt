<?php

	// Create_User form s
	
	$connection = mysqli_connect(DB_HOST, DB_USER , DB_PASS, DB_NAME)
	or die("Verbindung zur Datenbank konnte nicht hergestellt werden");
    
	// GET Variable erstellen, falls noch nicht gesetzt worden ist.
	if (!isset($_GET["typ"])) {
	    $_GET["typ"] = "";
	}
	
	/*
	 * Nur Admins dürfen Lehrer und weitere Admins erstellen. Deshalb
	 * prüfen um welchen eingeloggten User(Admin/Lehrer) es sich handelt.
	 *
	 */
	// AccountID feststellen
	$email = $_SESSION["email"];
	$query = "SELECT ID FROM accounts WHERE eMail like '$email'";
	$result =  mysqli_query($connection, $query) Or die("MySQL Fehler: " . mysqli_error($connection));
	while($row = mysqli_fetch_object($result)) {
		//print $row->ID;
		$id = $row->ID;
	}
	
	// In Tabelle "account_roles" mit der AccountID abfragen um welche roleID es sich handelt
	// roleID -> 1 = Administrator	;	roleID -> 2 = Lehrer 
	$query = "SELECT roleID FROM account_roles WHERE accountID='$id'";
	$result = mysqli_query($connection, $query) Or die("MySQL Fehler: " . mysqli_error($connection));
	while ($row = mysqli_fetch_object($result)) {
		$recht = $row->roleID;
	}
	//print $recht;	
	
	/*
	 * <?php
	     if ($recht=="2") print "disabled=\"disabled\""?>
	 */
?>
<form class="admin" action="./inc/create_user.inc.php" method="POST">
    <h1>Benutzer anlegen</h1>
    <fieldset id="auswahl">
    	<label>Typ: </label>
	    <input type="radio" name="typ" value="schueler" onclick="checkClickedUser();" <?php if($_GET["typ"] == "schueler") print "checked"?>><label> Schüler</label>
	    <input type="radio" name="typ" value="lehrer" onclick="checkClickedUser();" <?php if($_GET["typ"] == "lehrer") print "checked"  ?><?php
	     if ($recht=="2") print "disabled=\"disabled\""?>><label> Lehrer</label>
	    <input type="radio" name="typ" value="admin" onclick="checkClickedUser();" <?php if($_GET["typ"] == "admin") print "checked"?> <?php
	     if ($recht=="2") print "disabled=\"disabled\""?>><label> Administrator</label>
    </fieldset>
    <fieldset class="inputs">
    	<table>
<?php 
    if (($_GET["typ"] == "schueler") || ($_GET["typ"] == "lehrer") || ($_GET["typ"] == "admin")) {
?>
			<tr>
			    <td><label for="name">Name:</label></td>
			    <td><input id="name" type="text" name="name" placeholder="Name" autofocus required></td>
			</tr>
			<tr>
				<td><label for="vorname">Vorname:</label></td>
			    <td><input id="vorname" type="text" name="vorname" placeholder="Vorname" required></td>
			</tr>
<?php 
    }
?>
<?php 
    if (($_GET["typ"] == "lehrer" || $_GET["typ"] == "admin") && $recht == "1") {
?>
    		<tr>
    			<td><label for="password">Passwort:</label></td>
        		<td><input id="password" type="password" name="password" placeholder="Passwort" required></td>
        	</tr>
        	<tr>
        		<td><label for="passwordConfirmation">Passwort wiederholen:</label></td>
        		<td><input id="passwordConfirmation" type="password" name="passwordConfirmation" placeholder="Passwort wiederholen" required></td>
    		</tr>
    		<tr>
        		<td><label for="eMail">eMail:</label></td>
        		<td><input id="eMail" type="email" name="eMail" placeholder="eMail" required></td>
    		</tr>
    		<tr>
	    		<td colspan="2"><label>Rechte anpassen:</label></td>
	    	</tr>
	    	<tr>
		    	<td colspan="2">
			    	<table id="rechte"><tr>
					<?php 
					/*
					 * Listet die Rechte in einer Tabelle auf. Rechte können über Checkboxen entzogen oder gesetzt werden.
					 * In jedem Feld befindet sich eine Checkbox. Nach jeder dritten Checkbox fängt eine neue Reihe an.
					 * Es stehen nur Checkboxen zur Auswahl, derene Rechte der momentane Benutzer besitzt.
					 */
						$query = "SELECT rightID, rightName FROM rights";			
						$result =  mysqli_query($connection, $query) Or die("MySQL Fehler: " . mysqli_error());	
						$neueZeile = 0;
						while($row = mysqli_fetch_object($result)) {
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
				</td>
			</tr>
    </fieldset>
<?php   	
    }
    if ($_GET["typ"] == "schueler") {    	
?>
    <tr>
    	<td><label>Geburtsdatum:</label></td>
        <td><input id="geburtsdatum" type="date" name="geburtsdatum" placeholder="09.09.2002" required></td>
    </tr>   
    <tr>
    	<td><label>Geschlecht:</label></td>
    	<td><select name="geschlecht">
          <option value="">Bitte auswählen</option>
          <option value="M">Männlich</option>
          <option value="F">Weiblich</option>
        </select></td>
    </tr>
    <tr>
    	<td><label>Schule:</label></td>
        <td><input id="schule" type="text" name="schule" placeholder="Schule" required></td>
    </tr>
    <tr>
    	<td><label>Klasse:</label></td>
        <td><input id="klasse" type="text" name="klasse" placeholder="3" required></td>
    </tr>
<?php 
    }   
?> 
    	</table>
    </fieldset>
    <fieldset id="actions">
        <input type="submit" id="submit" value="Anlegen">
    </fieldset>
</form>