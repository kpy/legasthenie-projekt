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
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
	<script type="text/javascript" src="js/function.js"></script>
</head>
<body>
	<div id="mainwrapper">
		<!-- <div id="debug">
			<p><b>Debug:</b></br>
			<?php 
				var_dump($_GET);
				//var_dump($_SESSION["rights"]);
			?>
		</p>
		</div>
		
		-->
		<div id="content">
		<?php
			if(!isset($_SESSION["username"])) {
				include "inc/login_form.inc.php";
			} else {
				echo "<div id=\"logout_button\">\n<a href=\"inc/logout.inc.php\" alt=\"logout\">Logout</a>\n</div>\n";
				if(isset($_GET["section"])) {
					if($_GET["section"] == "create_user") {
						include "inc/create_user_form.inc.php";
					} elseif($_GET["section"] == "list_users") {
						include "inc/list_users.inc.php";
					}
				} else {
					include "inc/mainmenu.inc.php";
				}
			}
		?>
		</div>
	</div>
</body>
</html>