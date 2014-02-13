<?php
    /* create_user.inc.php */

    session_start();
    include 'function.inc.php';

    // Allgemeines Recht "Benutzer anlegen" prüfen
    if (is_null(hasRight(CREATE_USER, $_SESSION['rights']))) {
        header('Location: index.php');
    }

    // Verbindung zur Datenbank
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Verbindung überprüfen
//    define("CREATE_USER", "1");
//    define("EDIT_USER", "2");
//    define("DELETE_USER", "3");
//    define("DEACTIVATE_USER", "4");
//    define("ACTIVATE_USER", "5");
//    define("RESET_PASSWORD", "6");
//    define("CREATE_TEST", "7");
//    define("EDIT_TEST", "8");
//    define("DELETE_TEST", "9");
//    define("DEACTIVATE_TEST", "10");
//    define("ACTIVATE_TEST", "11");
//    define("UPLOAD_PIC", "12");
//    define("DELETE_PIC", "13");
//    define("EDIT_RIGHTS", "14");
//    define("DEACTIVATE_ADMIN", "15");
//    define("ACTIVATE_ADMIN", "16");
//    define("REVOKE_ADMIN_RIGHTS", "17");
//    define("ASSIGN_ADMIN_RIGHTS", "18");
//    define("LIST_USERS", "19");
//    define("CREATE_STUDENT", "20");
//    define("CREATE_TEACHER", "21");
//    define("CREATE_ADMIN", "22");
//    define("LIST_STUDENTS", "23");
    if (mysqli_connect_errno()) {
        echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
    }

    echo '<h2>Benutzer anlegen</h2>';

    /*
     * Je nach Usertyp, fülle die Variable $sql mit dem entsprechend angepassten
     * SQL Befehl. Werte werden aus der $_POST Variable übernommen. 
     */
    if (filter_input(INPUT_POST, 'typ') == 'schueler') {
        // SQL Statement vorbereiten
//        $sql = "INSERT INTO schueler (name, vorname, geburtsdatum, geschlecht, schule, klasse)
//		VALUES('$_POST[name]','$_POST[vorname]','$_POST[geburtsdatum]', '$_POST[geschlecht]','$_POST[schule]', '$_POST[klasse]')";
        $sql = "INSERT INTO schueler (name, vorname, geburtsdatum, geschlecht, schule, klasse)
		VALUES('" . filter_input(INPUT_POST, "name") . "', '"
                . filter_input(INPUT_POST, "vorname") . "', '"
                . filter_input(INPUT_POST, "geburtsdatum") . "', '"
                . filter_input(INPUT_POST, "geschlecht") . "', '"
                . filter_input(INPUT_POST, "schule") . "', '"
                . filter_input(INPUT_POST, "klasse") . "')";
    }
    if (filter_input(INPUT_POST, 'typ') == 'lehrer' || filter_input(INPUT_POST, 'typ') == 'admin') {
        // Generiere Salt und mit Hilfe des Passworts -> den Hash	
        $salt = blowfishSalt();
        $hash = crypt(filter_input(INPUT_POST, 'password'), $salt);
    }
    if (filter_input(INPUT_POST, 'typ') == 'admin') {
        // SQL Statement vorbereiten
        $sql = "INSERT INTO accounts (name, firstname, Username, Password_Salt, Password_Hash, active)
		VALUES('" . filter_input(INPUT_POST, "name") . "', '"
                . filter_input(INPUT_POST, "vorname") . "', '"
                . filter_input(INPUT_POST, "username") . ", "
                . "'$salt', "
                . "'$hash', "
                . "'1')";
    }
    if (filter_input(INPUT_POST, 'typ') == 'lehrer') {
        // SQL Statement vorbereiten
        $sql = "INSERT INTO accounts (name, firstname, Username, Password_Salt, Password_Hash, active)
		VALUES('" . filter_input(INPUT_POST, "name") . "', '"
                . filter_input(INPUT_POST, "vorname") . "', '"
                . filter_input(INPUT_POST, "username") . "', "
                . "'$salt', "
                . "'$hash', "
                . "'1')";
    }

    // SQL Befehl($sql) ausführen bzw. neuen User in die Tabelle "accounts" eintragen
    if (!mysqli_query($connection, $sql)) {
        die('Error: ' . mysqli_error($connection));
    }
    echo 'Eintrag erfolgreich durchgef&uuml;hrt.';

    /*
     * Lehrer und Admins benötigen einen weiteren Eintrag in der Tabelle "account_roles".
     * Diese teilt dem User seine Rechte zu. Dies kann erst nach dem Eintrag in der 
     * Tabelle "accounts" geschehen, da wir erst dann die benötigte AccountID erhalten.
     * Hierbei werden accountID und rightID(1=Admin 2=Lehrer) verknüpft. Spezielle Berechtigungen werden
     * mit der Tabelle "account_rights_adjust" geregelt.
     */
    if (filter_input(INPUT_POST, 'typ') == 'admin') {
        $rightID = '1';
    } elseif (filter_input(INPUT_POST, 'typ') == 'lehrer') {
        $rightID = '2';
    }
    if (filter_input(INPUT_POST, 'typ') == 'lehrer' || filter_input(INPUT_POST, 'typ') == 'admin') {
        // Gerade erstellte accountID(Primärschlüssel in "accounts") holen.
        $AccountID = "SELECT ID FROM accounts WHERE Password_Hash='$hash'";
        $result1 = mysqli_query($connection, $AccountID);
        $row = mysqli_fetch_array($result1);
        $benutzerID = $row[0];
        // accountID mit rightID SQL Statement vorbereiten und ausführen.
        $sql = "INSERT INTO account_roles(accountID, roleID) VALUES('$row[0]', '$rightID')";
        mysqli_query($connection, $sql);
        // Spezielle Berechtigungen in der Tabelle "account_rights_adjust" anpassen
        $rechte_post = filter_input(INPUT_POST, 'rights');
        $getListe = "SELECT * FROM rights";
        $result2 = mysqli_query($connection, $getListe);
        while ($row = $result2->fetch_assoc()) {
            if (!(array_search($row['rightName'], $rechte_post) !== FALSE)) {
                setAdjustment($benutzerID, $row['rightID'], -1);
            }
        }
    }

    // Verbindung schließen
    mysqli_close($connection);