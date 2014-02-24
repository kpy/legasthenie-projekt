<?php
    
    /* edit_user.inc.php */
    
    // Berechtigung überprüfen
    if (is_null(hasRight(EDIT_USER, $_SESSION['rights']))) {
        header('Location: index.php');
    }
    
    !isset($_POST['id']) ? header('Location: index.php?section=list_users') : false;
    
    $student = getUser(filter_input(INPUT_POST, 'id'));
    
//    var_dump($user);
    
    echo '<h2>Benutzer bearbeiten</h2><br>';
?>
<form class="admin" method="post" action="index.php?section=list_users">
    <fieldset class="inputs">
        <table>
            <tr>
                <td><label for="name">ID:</label></td>
                <td><input id="name" type="text" name="editID" value="<?php echo $student['ID'] ?>" readonly /></td>
            </tr>
            <tr>
                <td><label for="vorname">Vorname:</label></td>
                <td><input id="vorname" type="text" name="firstname" value="<?php echo $student['FirstName'] ?>" required /></td>
            </tr>
            <tr>
                <td><label for="nachname">Nachname:</label></td>
                <td><input id="nachname" type="text" name="name" value="<?php echo $student['Name'] ?>" required /></td>
            </tr>
            <tr>
                <td><label for="benutzername">Benutzername:</label></td>
                <td><input id="benutzername" type="text" name="username" value="<?php echo $student['username'] ?>" required /></td>
            </tr>
        </table>
    </fieldset>
    <input type="submit" value="&Auml;ndern" id="submit" name="change"/>
    <input type="submit" value="Abbrechen" id="submit" />
</form>