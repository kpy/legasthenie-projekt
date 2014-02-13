<?php
    
    /* delete_user.inc.php */
    
    // Berechtigung überprüfen
    if (is_null(hasRight(DELETE_USER, $_SESSION['rights']))) {
        header('Location: index.php');
    }
    
    !isset($_POST['id']) ? header('Location: index.php?section=list_users') : false;
    
    $student = getUser(filter_input(INPUT_POST, 'id'));
    
//    var_dump($user);
    
    echo '<h2>Benutzer l&ouml;schen</h2><br>';
    
    echo 'Wollen Sie wirklich folgenden Benutzer aus der Datenbank entfernen?<br><br>';
?>

<table>
    <?php
        $student['active'] == 1 ? $act = 'Ja' : $act = 'Nein';
        echo '<tr>'
                . '<td>ID:</td>'
                . '<td>' . $student['ID'] . '</td>'
            . '</tr>'
            . '<tr>'
                . '<td>Name:</td>'
                . '<td>' . $student['Name'] . '</td>'
            . '</tr>'
            . '<tr>'
                . '<td>Vorname:</td>'
                . '<td>' . $student['FirstName'] . '</td>'
            . '</tr>'
            . '<tr>'
                . '<td>Benutzername:</td>'
                . '<td>' . $student['username'] . '</td>'
            . '</tr>'
            . '<tr>'
                . '<td>Aktiv:</td>'
                . '<td>' . $act . '</td>'
            . '</tr>';
    ?>
</table>
<br>
<table>
    <?php
        echo '<tr>'
                . '<td>'
                    . '<form method="post" action="index.php?section=list_users">'
                    . '<input type="hidden" name="deleteID" value="' . $student['ID'] . '">'
                    . '<input type="submit" value="Ja" id="submit">'
                    . '</form>'
                . '</td>'
                . '<td>'
                    . '<form method="post" action="index.php?section=list_users">'
                    . '<input type="submit" value="Nein" id="submit">'
                    . '</form>'
                . '</td>'
            . '</tr>';
    ?>
</table>