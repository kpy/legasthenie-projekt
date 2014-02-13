<?php
    // Create_User form s
    // Allgemeines Recht "Benutzer anlegen" prüfen
    if (is_null(hasRight(CREATE_USER, $_SESSION['rights']))) {
        header('Location: index.php');
    }

    // Datenbank Verbindung aufbauen
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');

    // GET Variable erstellen, falls noch nicht gesetzt worden ist.
    if (!isset($_GET['typ'])) {
        $_GET['typ'] = '';
    }
?>

<form class="admin" action="./inc/create_user.inc.php" method="POST">

    <h1>Benutzer anlegen</h1>

    <fieldset id="auswahl">
        <label>Typ: </label>

        <input type="radio"
               name="typ"
               value="schueler"
               onclick="checkClickedUser();"
               <?php if (empty(hasRight(CREATE_STUDENT, $_SESSION['rights']))) print 'disabled' ?>
               <?php if (filter_input(INPUT_GET, 'typ') == 'schueler') print 'checked' ?> />
        <label> Sch&uuml;ler</label>

        <input type="radio"
               name="typ"
               value="lehrer"
               onclick="checkClickedUser();"
               <?php if (empty(hasRight(CREATE_TEACHER, $_SESSION['rights']))) print 'disabled' ?>
               <?php if (filter_input(INPUT_GET, 'typ') == 'lehrer') print 'checked' ?> >
        <label> Lehrer</label>

        <input type="radio"
               name="typ"
               value="admin"
               onclick="checkClickedUser();"
               <?php if (empty(hasRight(CREATE_ADMIN, $_SESSION['rights']))) print 'disabled' ?>
               <?php if (filter_input(INPUT_GET, 'typ') == 'admin') print 'checked' ?> >
        <label> Administrator</label>
    </fieldset>

    <fieldset class="inputs">
        <table>
            <?php
                if ((filter_input(INPUT_GET, 'typ') == 'schueler' && hasRight(CREATE_STUDENT, $_SESSION['rights'])) ||
                        (filter_input(INPUT_GET, 'typ') == 'lehrer' && hasRight(CREATE_TEACHER, $_SESSION['rights'])) ||
                        (filter_input(INPUT_GET, 'typ') == 'admin' && hasRight(CREATE_ADMIN, $_SESSION['rights']))) {
                    ?>

                    <tr>
                        <td><label for="name">Name:</label></td>
                        <td><input id="name" type="text" name="name" placeholder="Name" autofocus required></td>
                    </tr>

                    <tr>
                        <td><label for="vorname">Vorname:</label></td>
                        <td><input id="vorname" type="text" name="vorname" placeholder="Vorname" required></td>
                    </tr>

                    <?php
                }
            ?>
            <?php
                if ((filter_input(INPUT_GET, 'typ') == 'lehrer' && hasRight(CREATE_TEACHER, $_SESSION['rights'])) ||
                        (filter_input(INPUT_GET, 'typ') == 'admin' && hasRight(CREATE_ADMIN, $_SESSION['rights']))) {
                    ?>

                    <tr>
                        <td><label for="password">Passwort:</label></td>
                        <td><input id="password" type="password" name="password" placeholder="Passwort" required></td>
                    </tr>

                    <tr>
                        <td><label for="passwordConfirmation">Passwort wiederholen:</label></td>
                        <td><input id="passwordConfirmation" type="password" name="passwordConfirmation" placeholder="Passwort wiederholen" required></td>
                    </tr>

                    <tr>
                        <td><label for="Username">Benutzername:</label></td>
                        <td><input id="username" type="username" name="username" placeholder="Benutzername" required></td>
                    </tr>

                    <tr>
                        <td colspan="2"><label>Rechte anpassen:</label></td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <table id="rechte"><tr>
                                    <?php
                                    /*
                                     * Listet die Rechte in einer Tabelle auf. Rechte können über Checkboxen entzogen oder gesetzt werden.
                                     * In jedem Feld befindet sich eine Checkbox. Nach jeder dritten Checkbox fängt eine neue Reihe an.
                                     * Es stehen nur Checkboxen zur Auswahl, deren Rechte der momentane Benutzer besitzt.
                                     */
                                    $query = "SELECT rightID, rightName FROM rights";
                                    $result = mysqli_query($connection, $query) Or die('MySQL Fehler: ' . mysqli_error());
                                    $neueZeile = 0;
                                    while ($row = mysqli_fetch_object($result)) {
                                        $neueZeile++;
                                        if ($neueZeile == 3) {
                                            print '<tr>';
                                        }
                                        print '<td>';
                                        // Rechte des eingeloggten Benutzers mit den Checkboxen anpassen
                                        if (!is_null(hasRight($row->rightID, $_SESSION['rights']))) {
                                            print "<input type=\"checkbox\" name=\"rights[]\" value=\"$row->rightName\" checked>" . $row->rightName . "</input>";
                                        } else {
                                            print "<input type=\"checkbox\" name=\"rights[]\" value=\"$row->rightName\" disabled=\"disabled\">" . $row->rightName . "</input>";
                                        }
                                        print '</td>';
                                        if ($neueZeile == 3) {
                                            print '</tr>';
                                            $neueZeile = 0;
                                        }
                                    }
                                    ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php
                }
                
                if (filter_input(INPUT_GET, 'typ') == 'schueler' && hasRight(CREATE_STUDENT, $_SESSION['rights'])) {
                    ?>
                    
                    <tr>
                        <td><label>Geburtsdatum:</label></td>
                        <td><input id="geburtsdatum" type="date" name="geburtsdatum" placeholder="09.09.2002" required></td>
                    </tr>
                    
                    <tr>
                        <td><label>Geschlecht:</label></td>
                        <td>
                            <select name="geschlecht">
                                <option value="">Bitte ausw&auml;hlen</option>
                                <option value="M">M&auml;nnlich</option>
                                <option value="F">Weiblich</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td><label>Schule:</label></td>
                        <td><input id="schule" type="text" name="schule" placeholder="Schule" required></td>
                    </tr>
                    
                    <tr>
                        <td><label>Klasse:</label></td>
                        <td><input id="klasse" type="text" name="klasse" placeholder="3" required></td>
                    </tr>
                    
                    <?php
                }
            ?> 
        </table>
    </fieldset>
    
    <fieldset id="actions">
        <input type="submit" id="submit" value="Anlegen">
    </fieldset>
</form>