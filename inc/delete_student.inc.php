<?php
    
    /* delete_student.inc.php */
    
    !isset($_POST['id']) ? header('Location: index.php?section=list_students') : false;
    
    $student = getStudent(filter_input(INPUT_POST, 'id'));
    
    var_dump($student);
    
    echo '<h2>Sch&uuml;ler l&ouml;schen</h2><br>';
    
    echo 'Wollen Sie wirklich folgenden Sch&uuml;ler aus der Datenbank entfernen?<br><br>';
?>

<table>
    <?php
        echo '<tr>'
                . '<td>ID:</td>'
                . '<td>' . $student['id'] . '</td>'
            . '</tr>'
            . '<tr>'
                . '<td>Name:</td>'
                . '<td>' . $student['name'] . '</td>'
            . '</tr>'
            . '<tr>'
                . '<td>Vorname:</td>'
                . '<td>' . $student['vorname'] . '</td>'
            . '</tr>'
            . '<tr>'
                . '<td>Geburtsdatum:</td>'
                . '<td>' . $student['geburtsdatum'] . '</td>'
            . '</tr>'
            . '<tr>'
                . '<td>Geschlecht:</td>'
                . '<td>' . $student['geschlecht'] . '</td>'
            . '</tr>'
            . '<tr>'
                . '<td>Schule:</td>'
                . '<td>' . $student['schule'] . '</td>'
            . '</tr>'
            . '<tr>'
                . '<td>Klasse:</td>'
                . '<td>' . $student['klasse'] . '</td>'
            . '</tr>';
    ?>
</table>
<br>
<table>
    <?php
        echo '<tr>'
                . '<td>'
                    . '<form method="post" action="index.php?section=list_students">'
                    . '<input type="hidden" name="deleteID" value="' . $student['id'] . '">'
                    . '<input type="submit" value="Ja" id="submit">'
                    . '</form>'
                . '</td>'
                . '<td>'
                    . '<form method="post" action="index.php?section=list_students">'
                    . '<input type="submit" value="Nein" id="submit">'
                    . '</form>'
                . '</td>'
            . '</tr>';
    ?>
</table>