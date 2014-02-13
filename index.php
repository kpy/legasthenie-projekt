<?php
    /* index.php */

    session_start();
    error_reporting(E_ALL);
    include 'inc/function.inc.php';
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
            
            <div id="debug">
                    <p><b>Debug:</b></br>
            <?php
                echo 'GET-Variable: ';
                var_dump(filter_input_array(INPUT_GET));
                echo '<br>';
                echo 'POST-Variable: ';
                var_dump(filter_input_array(INPUT_POST));
                echo '<br>';
                echo 'Gespeicherte Rechte in der Session: ';
                isset($_SESSION['rights']) ? var_dump($_SESSION['rights']) : print 'Keine Rechte in der Session gespeichert';
            ?>
            </p>
            </div>
            
            <div id="content">
                <?php
                    if (!isset($_SESSION['username'])) {
                        include 'inc/login_form.inc.php';
                    } else {
                        echo '<div id="logout_button">'
                                . '<a href="index.php" alt="menu">  Men&uuml;  </a>'
                            . '</div>';
                        
                        echo '<div id="logout_button">'
                                . '<a href="inc/logout.inc.php" alt="logout">  Logout  </a>'
                            . '</div>';
                        
                        if (isset($_GET['section'])) {
                            if (filter_input(INPUT_GET, 'section') == 'create_user') {
                                include 'inc/create_user_form.inc.php';
                            } elseif (filter_input(INPUT_GET, 'section') == 'list_users') {
                                include 'inc/list_users.inc.php';
                            } elseif (filter_input(INPUT_GET, 'section') == 'list_students') {
                                include 'inc/list_students.inc.php';
                            } elseif (filter_input(INPUT_GET, 'section') == 'delete_user') {
                                include 'inc/delete_user.inc.php';
                            }
                        } else {
                            include 'inc/mainmenu.inc.php';
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>