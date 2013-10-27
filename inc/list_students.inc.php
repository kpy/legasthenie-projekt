<?php

	/* list_students.inc.php */

	// Berechtigung überprüfen
	if(is_null(hasRight(LIST_STUDENTS, $_SESSION['rights']))) {
	    header( 'Location: index.php' ) ;
	}
	
	// Alle Accounts aus der Datenbank in ein Array speichern
	$students = getStudents();

	echo "<h2>Schüler auflisten</h2>";
?>
<table id="listTable" cellspacing="0">
<tr>
  <th scope="col" class="spec">ID</th>
  <th scope="col" >Vorname</th>
  <th scope="col" >Name</th>
  <th scope="col" >Geburtsdatum</th>
  <th scope="col" >Geschlecht</th>
  <th scope="col" >Schule</th>
  <th scope="col" >Klasse</th>
  <th scope="col" >Bearbeiten</th>
  <th scope="col" >Löschen</th>
</tr>
<?php 
	foreach($students as $u) {
		
	 	// Tabelle erzeugen, ein Durchgang = eine Reihe
		echo "<tr><th scope=\"row\" class=\"spec\">" .$u[0]. "</th><td>" .$u[2]. "</td><td>" .$u[2]. "</td><td>" .$u[3]. "</td><td>" .$u[4].  "</td><td>" .$u[5]. "</td><td>"
		.$u[6]. "</td><td>" . "
		<form name=\"input\" action=\"edit_student_page.html\" method=\"post\"><input type=\"hidden\" name=\"id\" value=\"" . $u[0] ."\"><input type=\"submit\" value=\"Bearbeiten\" id=\"submit\"></form>
		" . "</td><td>" . "
		<form name=\"input\" action=\"delete_student_page.html\" method=\"post\"><input type=\"hidden\" name=\"id\" value=\"" . $u[0] ."\"><input type=\"submit\" value=\"Löschen\" id=\"submit\"></form>
	 	" . "</td></tr>";	
			
	}
?>
</table>



