<?php
    /* mainmenu.inc.php */
    $rights = $_SESSION['rights'];

    // Vorerst alle Berechtigungen ausgeben und wenn vorhanden, Link hinterlegen
    if (is_null($rights)) {
        echo '<h3>Sie haben keine Berechtigungen</h3>';
    } else {
        echo '<h3>Ihre Berechtigungen: (' . count($rights) . ')</h3>';
        echo '<ul>';
        if (!is_null($r = hasRight(CREATE_USER, $rights))) {
            echo '<li><a href="index.php?section=create_user">' . $r . '</a></li>';
        }
        if (!is_null($r = hasRight(EDIT_USER, $rights))) {
            echo '<li>' . $r . ' (in Benutzer auflisten)</li>';
        }
        if (!is_null($r = hasRight(DELETE_USER, $rights))) {
            echo '<li>' . $r . ' (in Benutzer auflisten)</li>';
        }
        if (!is_null($r = hasRight(DEACTIVATE_USER, $rights))) {
            echo '<li>' . $r . ' (in Benutzer auflisten)</li>';
        }
        if (!is_null($r = hasRight(ACTIVATE_USER, $rights))) {
            echo '<li>' . $r . ' (in Benutzer auflisten)</li>';
        }
        if (!is_null($r = hasRight(RESET_PASSWORD, $rights))) {
            echo '<li>' . $r . ' (noch nicht implementiert)</li>';
        }
        if (!is_null($r = hasRight(CREATE_TEST, $rights))) {
            echo '<li>' . $r . ' (Zusatz)</li>';
        }
        if (!is_null($r = hasRight(EDIT_TEST, $rights))) {
            echo '<li>' . $r . ' (Zusatz)</li>';
        }
        if (!is_null($r = hasRight(DELETE_TEST, $rights))) {
            echo '<li>' . $r . ' (Zusatz)</li>';
        }
        if (!is_null($r = hasRight(DEACTIVATE_TEST, $rights))) {
            echo '<li>' . $r . ' (Zusatz)</li>';
        }
        if (!is_null($r = hasRight(ACTIVATE_TEST, $rights))) {
            echo '<li>' . $r . ' (Zusatz)</li>';
        }
        if (!is_null($r = hasRight(UPLOAD_PIC, $rights))) {
            echo '<li>' . $r . ' (Zusatz)</li>';
        }
        if (!is_null($r = hasRight(DELETE_PIC, $rights))) {
            echo '<li>' . $r . ' (Zusatz)</li>';
        }
        if (!is_null($r = hasRight(EDIT_RIGHTS, $rights))) {
            echo '<li>' . $r . ' (noch nicht implementiert)</li>';
        }
        if (!is_null($r = hasRight(DEACTIVATE_ADMIN, $rights))) {
            echo '<li>' . $r . ' (nicht sicher, ob implementiert)</li>';
        }
        if (!is_null($r = hasRight(ACTIVATE_ADMIN, $rights))) {
            echo '<li>' . $r . ' (nicht sicher, ob implementiert)</li>';
        }
        if (!is_null($r = hasRight(REVOKE_ADMIN_RIGHTS, $rights))) {
            echo '<li>' . $r . ' (nicht sicher, ob implementiert)</li>';
        }
        if (!is_null($r = hasRight(ASSIGN_ADMIN_RIGHTS, $rights))) {
            echo '<li>' . $r . ' (nicht sicher, ob implementiert)</li>';
        }
        if (!is_null($r = hasRight(LIST_USERS, $rights))) {
            echo '<li><a href="index.php?section=list_users">' . $r . '</a></li>';
        }
        if (!is_null($r = hasRight(CREATE_STUDENT, $rights))) {
            echo '<li>' . $r . ' (in Benutzer anlegen)</li>';
        }
        if (!is_null($r = hasRight(CREATE_TEACHER, $rights))) {
            echo '<li>' . $r . ' (in Benutzer anlegen)</li>';
        }
        if (!is_null($r = hasRight(CREATE_ADMIN, $rights))) {
            echo '<li>' . $r . ' (in Benutzer anlegen)</li>';
        }
        if (!is_null($r = hasRight(LIST_STUDENTS, $rights))) {
            echo '<li><a href="index.php?section=list_students">' . $r . '</a></li>';
        }
        echo '<li><a href="index.php?section=test1">Test 1 starten</a></li>';
        echo '</ul>';
    }