<?php
	/* mainmenu.inc.php */
	$rights = $_SESSION["rights"];

	// Vorerst alle Berechtigungen ausgeben und wenn vorhanden, Link hinterlegen
	if(is_null($rights)) {
		echo "<h3>Sie haben keine Berechtigungen</h3>\n";
	} else {
		echo "<h3>Ihre Berechtigungen: (".count($rights).")</h3>\n";
		echo "<ul>\n";
		if(!is_null($r = hasRight(CREATE_USER, $rights))) echo "<li><a href=\"index.php?section=create_user\">".$r."</a></li>\n";
		if(!is_null($r = hasRight(EDIT_USER, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(DELETE_USER, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(DEACTIVATE_USER, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(ACTIVATE_USER, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(RESET_PASSWORD, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(CREATE_TEST, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(EDIT_TEST, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(DELETE_TEST, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(DEACTIVATE_TEST, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(ACTIVATE_TEST, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(UPLOAD_PIC, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(DELETE_PIC, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(EDIT_RIGHTS, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(DEACTIVATE_ADMIN, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(ACTIVATE_ADMIN, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(REVOKE_ADMIN_RIGHTS, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(ASSIGN_ADMIN_RIGHTS, $rights))) echo "<li>".$r."</li>\n";
		if(!is_null($r = hasRight(LIST_USERS, $rights))) echo "<li><a href=\"index.php?section=list_users\">".$r."</a></li>\n";
		if(!is_null($r = hasRight(LIST_STUDENTS, $rights))) echo "<li><a href=\"index.php?section=list_students\">".$r."</a></li>\n";
		echo "</ul>\n";
	}
?>