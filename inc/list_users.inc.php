<?php
	/* list_users.inc.php */
	echo "<h2>Benutzer auflisten</h2>";
	if(is_null(hasRight(LIST_USERS, $_SESSION['rights']))) {
	    header( 'Location: index.php' ) ;
	}
	$users = getUsers();

	if(!is_null($users)) {
		echo "<ul>\n";
		foreach($users as $u) {
			echo "<li>".$u["Name"].", ".$u["FirstName"]."</li>\n";
		}
		echo "</ul>\n";
	}
?>