<?php
    /* login.inc.php */

    // Im Live-System entfernen
    error_reporting(E_ALL);

    // Benötigte Dateien einbinden
    include 'function.inc.php';
    session_start();

    // Verbindung zur Datenbank aufbauen
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');

    // Abfrage des übergeben Namens auf der Datenbank
    // Test auf SQL-Injektion fehlt noch
    $username = $_POST['email'];
    $query = "SELECT ID, username, Password_Salt, Password_Hash FROM accounts WHERE username LIKE '$username' AND active = 1 LIMIT 1";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_object($result);
    $passwordHash = crypt($_POST['password'], $row->Password_Salt);

    // Vergleiche Passwort-Hashes
    if ($row->Password_Hash === $passwordHash) {
        $_SESSION['username'] = $username;
        $rights = getRightsWithName($row->ID);
        $_SESSION['rights'] = $rights;
        header('Location: ../index.php');
    } else {
        echo 'Benutzername und/oder Passwort waren falsch. <a href="../index.php">Login</a>';
    }