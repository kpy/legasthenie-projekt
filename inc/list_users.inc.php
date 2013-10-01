<?php
	/* list_users.inc.php */
	if(is_null(hasRight(LIST_USERS, $_SESSION['rights']))) {
	    header( 'Location: index.php' ) ;
	}

	$users = getUsers();

	echo "<h2>Benutzer auflisten</h2>";
	if(!is_null($users)) {
		echo "<ul>\n";
		foreach($users as $u) {
			echo "<li>".$u[1].", ".$u[2]."</li>\n";
		}
		echo "</ul>\n";
	}
?>
