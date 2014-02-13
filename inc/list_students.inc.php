<?php
    /* list_students.inc.php */

    // Berechtigung überprüfen
    if (is_null(hasRight(LIST_STUDENTS, $_SESSION['rights']))) {
        header('Location: index.php');
    }
    
    // Überprüfe POST-Werte nach Löschen eines Benutzers
    isset($_POST['deleteID']) ? deleteStudent(filter_input(INPUT_POST, 'deleteID')) : false;

    // Alle Accounts aus der Datenbank in ein Array speichern
    $students = getStudents();

    echo '<h2>Sch&uuml;ler auflisten</h2>';
?>

<table id="listTable" cellspacing="0">
    <tr>
        <th scope="col" class="spec">ID</th>
        <th scope="col" >Vorname</th>
        <th scope="col" >Name</th>
        <th scope="col" >Geburtsdatum</th>
        <th scope="col" >M/W</th>
        <th scope="col" >Schule</th>
        <th scope="col" >Klasse</th>
        <th scope="col" >Bearbeiten</th>
        <th scope="col" >L&ouml;schen</th>
    </tr>
    <?php
        foreach ($students as $u) {

            // Tabelle erzeugen, ein Durchgang = eine Reihe
            echo '<tr>'
            . '<th scope="row" class="spec">' . $u[0] . '</th>'
            . '<td>' . $u[2] . '</td>'
            . '<td>' . $u[1] . '</td>'
            . '<td>' . $u[3] . '</td>'
            . '<td>' . $u[4] . '</td>'
            . '<td>' . $u[5] . '</td>'
            . '<td>' . $u[6] . '</td>'
            . '<td>'
                . '<form name="input" action="edit_student_page.html" method="post">'
                    . '<input type="hidden" name="id" value="' . $u[0] . '">'
                    . '<input type="submit" value="Bearbeiten" id="submit">'
                . '</form>'
            . '</td>'
            . '<td>'
                . '<form name="input" action="index.php?section=delete_student" method="post">'
                    . '<input type="hidden" name="id" value="' . $u[0] . '">'
                    . '<input type="submit" value="L&ouml;schen" id="submit">'
                . '</form>'
            . '</td>'
            . '</tr>';
        }
    ?>
</table>