<?php

	/* list_users.inc.php */

	// Berechtigung überprüfen
	if(is_null(hasRight(LIST_USERS, $_SESSION['rights']))) {
	    header( 'Location: index.php' ) ;
	}
	
	// Überprüfe POST-Werte nach Aktivierung/Deaktivierungs Aufruf
	isset($_POST['activeInt']) ? setActive($_POST['activeInt'], $_POST['activeID']) : false;
	
	
	
	// Alle Accounts aus der Datenbank in ein Array speichern
	$users = getUsers();

	echo "<h2>Benutzer auflisten</h2>";
?>
<table id="listTable" cellspacing="0">
<tr>
  <th scope="col" class="spec">ID</th>
  <th scope="col" >Username</th>
  <th scope="col" >Vorname</th>
  <th scope="col" >Nachname</th>
  <th scope="col" >Typ</th>
  <th scope="col" >Aktiv</th>
  <th scope="col" >Bearbeiten</th>
  <th scope="col" >Löschen</th>
</tr>
<?php 
	foreach($users as $u) {
		// Ermittle Typ des aktuellen Datensatzes(Lehrer oder Admin?)
		$typ = getTyp(getID($u[3]));
		$typ == "1" ? $typ = "Admin" : $typ = "Lehrer";
		
		// Ermittle ob Account de/aktiviert ist und setze entsprechenden Link
		if ($u[6] == "1") {
			$active = "<form name=\"input\" action=\"\" method=\"post\"><input type=\"hidden\" name=\"activeInt\" value=\"0\"><input type=\"hidden\" name=\"activeID\" value=\"" . $u[0] . "\"><input type=\"submit\" value=\"Deaktivieren\" id=\"submit\"></form>";
		} else {
			$active = "<form name=\"input\" action=\"\" method=\"post\"><input type=\"hidden\" name=\"activeInt\" value=\"1\"><input type=\"hidden\" name=\"activeID\" value=\"" . $u[0] . "\"><input type=\"submit\" value=\"Aktivieren\" id=\"submit\"></form>";
		}
		
	 	// Tabelle erzeugen, ein Durchgang = eine Reihe
		echo "<tr><th scope=\"row\" class=\"spec\">" .$u[0]. "</th><td>" .$u[3]. "</td><td>" .$u[2]. "</td><td>" .$u[1].  "</td><td>" .$typ. "</td><td>"
		.$active. "</td><td>" . "
		<form name=\"input\" action=\"edit_user_page.html\" method=\"post\"><input type=\"hidden\" name=\"id\" value=\"" . $u[0] ."\"><input type=\"submit\" value=\"Bearbeiten\" id=\"submit\"></form>
		" . "</td><td>" . "
		<form name=\"input\" action=\"delete_user_page.html\" method=\"post\"><input type=\"hidden\" name=\"id\" value=\"" . $u[0] ."\"><input type=\"submit\" value=\"Löschen\" id=\"submit\"></form>
	 	" . "</td></tr>";		
	}
?>
</table>



