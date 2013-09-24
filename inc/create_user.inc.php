<?php
	/* create_user.inc.php */
	echo "<h2>Benutzer anlegen</h2>";
	if(is_null(hasRight(CREATE_USER, $_SESSION['rights']))) {
	    header( 'Location: index.php' ) ;
	}
	echo $_POST['email'];
	// $users = getUsers();
?>