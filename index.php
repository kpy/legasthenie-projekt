<?php
	/* index.php */

	session_start();
	error_reporting(E_ALL);
	include "inc/function.inc.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Legasthenie-Projekt</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
</head>
<body>
	<div id="mainwrapper">
		<div id="debug">
			<p><b>Debug:</b></br>
			<?php 
				var_dump($_GET);
			?>
		</p>
		</div>
		<div id="content">
		<?php
			if(!isset($_SESSION["email"])) {
				include "inc/login_form.inc.php";
			} else {
				echo "<div id=\"logout_button\">\n<a href=\"inc/logout.inc.php\" alt=\"logout\">Logout</a>\n</div>\n";

				if($_GET["section"] == "create_user") {
					include "inc/create_user_form.inc.php";
				} elseif($_GET["section"] == "list_users") {
					include "inc/list_users.inc.php";
				} else {
					include "inc/mainmenu.inc.php";
				}
			}
		?>
		</div>
	</div>
</body>
</html>