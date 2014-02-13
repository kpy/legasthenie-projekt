<?php
    /* function.inc.php */

    include 'constant.inc.php';

    /**
     * Generate a random salt in the crypt(3) standard Blowfish format.
     *
     * @param int $cost Cost parameter from 4 to 31.
     *
     * @throws Exception on invalid cost parameter.
     * @return string A Blowfish hash salt for use in PHP's crypt()
     */
    function blowfishSalt($cost = 13) {
        if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
            throw new Exception('cost parameter must be between 4 and 31');
        }
        $rand = array();
        for ($i = 0; $i < 8; $i += 1) {
            $rand[] = pack('S', mt_rand(0, 0xffff));
        }
        $rand[] = substr(microtime(), 2, 6);
        $rand = sha1(implode('', $rand), true);
        $salt = '$2a$' . sprintf('%02d', $cost) . '$';
        $salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));
        return $salt;
    }

    /**
     * Liefert ein Array mit den Rechten eines bestimmten Benutzers zurück.
     *
     * @param int $id ID des Benutzers
     *
     * @return array Rechte des Benutzers
     */
    function getRights($id) {
        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');

        $query = "SELECT final.rightID, IF(SUM(final.hasRight)>=1, 1, 0) AS hasRight 
	              FROM (
	                (SELECT r.rightID, IF(SUM(counter)>=1, 1, 0) AS hasRight
	                    FROM rights r 
	                    LEFT JOIN 
	                    (SELECT rr.*, 1 AS counter
	                    FROM role_rights rr, account_roles ar
	                    WHERE ar.roleID = rr.roleID
	                    AND ar.accountID = '$id') rr 
	                    ON r.rightID = rr.rightID
	                    GROUP BY r.rightID)

	                    UNION

	                    (SELECT a.rightID, a.adjustment AS hasRight
	                        FROM account_rights_adjust a
	                        WHERE a.accountID = '$id')
	                ) AS final
	                GROUP BY final.rightID";
        $ret = mysqli_query($connection, $query) Or die('MySQL Fehler: ' . mysqli_error());

        $result = mysqli_fetch_all($ret);

        return $result;
    }

    /**
     * Liefert ein Array mit den Rechten eines bestimmten Benutzers inklusive der Bezeichnungen zurück.
     *
     * @param int $id ID des Benutzers
     *
     * @return array Rechte des Benutzers
     */
    function getRightsWithName($id) {
        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');

        $query = "SELECT final.rightID, final.rightName, IF(SUM(final.hasRight)>=1, 1, 0) AS hasRight FROM (
	                (SELECT r.rightID, r.rightName, IF(SUM(counter)>=1, 1, 0) AS hasRight
	                FROM rights r 
	                    LEFT JOIN 
	                        (SELECT rr.*, 1 AS counter
	                        FROM role_rights rr, account_roles ar
	                        WHERE ar.roleID = rr.roleID
	                        AND ar.accountID = '$id') rr 
	                    ON r.rightID = rr.rightID
	                GROUP BY r.rightID)

	                UNION

	                (SELECT r.rightID, r.rightName, a.adjustment AS hasRight
	                FROM rights r, account_rights_adjust a
	                WHERE   r.rightID = a.rightID
	                    AND a.accountID = '$id')
	                ) AS final
	            GROUP BY final.rightID";
        $ret = mysqli_query($connection, $query) Or die('MySQL Fehler: ' . mysqli_error());

        $result = mysqli_fetch_all($ret);

        return $result;
    }

    /**
     * Überprüft für einen Benutzer, ob ein bestimmtes Recht vorhanden ist
     * Überprüfung jetzt über den Index
     * 		- $r[0]		=>		rightID
     * 		- $r[1]		=>		rightName
     * 		- $r[2]		=>		hasRight
     *
     * @param string $id 		rightID
     * @param array $rights 	Array mit Benutzerrechten
     *
     * @return string 			Name der Berechtigung, sonst NULL
     */
    function hasRight($id, $rights) {
        $result = '';
        foreach ($rights as $r) {
            if ($r[0] == $id && $r[2] == 1)
                $result = $r[1];
        }
        return $result;
    }

    /**
     * Gibt alle Benutzer zurück
     *
     * @return array Benutzer
     */
    function getUsers() {
        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');
        $query = "SELECT * FROM accounts ORDER BY ID ASC";
        $ret = mysqli_query($connection, $query) OR die('MySQL Fehler: ' . mysqli_error());
        $result = mysqli_fetch_all($ret);

        return $result;
    }
    
    /**
     * Gibt den Benutzer mit der ID $id
     * 
     * @param int $id
     * @return array Benutzer
     */
    function getUser($id) {
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');
        $query = "SELECT * FROM accounts WHERE ID = $id LIMIT 1";
        $res = mysqli_query($link, $query);
        $result = mysqli_fetch_array($res);
        mysqli_close($link);
        
        return $result;
    }

    /**
     * Gibt alle Schüler zurück
     *
     * @return array Schüler
     */
    function getStudents() {
        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');
        $query = "SELECT * FROM schueler ORDER BY ID ASC";
        $ret = mysqli_query($connection, $query) OR die('MySQL Fehler: ' . mysqli_error());
        $result = mysqli_fetch_all($ret);

        return $result;
    }
    
    /**
     * Gibt den Schüler mit der ID $id zurück
     * 
     * @param int $id
     * @return array Schüler
     */
    function getStudent($id) {
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');
        $query = "SELECT * FROM schueler WHERE ID = $id LIMIT 1";
        $res = mysqli_query($link, $query) or die('MySQL Fehler: ' . mysqli_error());
        $result = mysqli_fetch_array($res);
        mysqli_close($link);
        
        return $result;
    }

    /**
     * Gibt die ID eines Accounts zurück
     * 
     * @param string $username	Username
     * 
     * @return int	 ID
     */
    function getID($username) {
        $connectionGetID = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');
        $sqlGetID = "SELECT ID FROM accounts WHERE username='$username';";
        $resultGetID = mysqli_query($connectionGetID, $sqlGetID) Or die('MySQL Fehler: ' . mysqli_error($connectionGetID));
        $rowGetID = $resultGetID->fetch_assoc();
        mysqli_close($connectionGetID);
        return $rowGetID['ID'];
    }

    /**
     * Setzt oder entzieht Berechtigungen. Vergibt oder entzieht spezielle Rechte
     * für Admins und Lehrer.
     * 
     * @param Int 	$accountID
     * @param Int	$rightID
     * @param Int	$adjustment ( 1 || -1 )
     */
    function setAdjustment($accountID, $rightID, $adjustment) {
        $connectionAdjust = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');
        $sqlAdjust = "INSERT INTO account_rights_adjust (accountID, rightID, adjustment) VALUES('$accountID', '$rightID', '$adjustment')";
        mysqli_query($connectionAdjust, $sqlAdjust) Or die('MySQL Fehler: ' . mysqli_error($connectionAdjust));
        mysqli_close($connectionAdjust);
    }

    /**
     * Gibt den Typ eines Accounts zurück->Lehrer || Admin
     * 
     * @param Int	 $id
     * 
     * @return String $rowGetTyp['accountID']
     */
    function getTyp($id) {
        $connectionGetTyp = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');
        $sqlGetTyp = "SELECT accountID FROM account_roles WHERE roleID='$id';";
        $resultGetID = mysqli_query($connectionGetTyp, $sqlGetTyp) Or die('MySQL Fehler: ' . mysqli_error($connectionGetTyp));
        $rowGetTyp = $resultGetID->fetch_assoc();
        mysqli_close($connectionGetTyp);
        return $rowGetTyp['accountID'];
    }

    /**
     * Aktiviert oder deaktiviert einen Account
     * 1 = aktiveren || 0 = deaktivieren
     * 
     * @param TinyInt $tint
     * @param Int	$accountID
     */
    function setActive($tint, $accountID) {
        $connectionSetActive = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');
        $sqlSetActive = "UPDATE accounts SET active='$tint' WHERE id='$accountID'";
        mysqli_query($connectionSetActive, $sqlSetActive) Or die('MySQL Fehler: ' . mysqli_error($connectionSetActive));
        mysqli_close($connectionSetActive);
    }
    
    /**
     * Löscht den Benutzer mit der ID $id
     * 
     * @param int $id
     */
    function deleteUser($id) {
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');
        $query = "DELETE FROM accounts WHERE ID = '$id'";
        mysqli_query($link, $query) or die('MySQL Fehler: ' . mysqli_error($link));
        mysqli_close($link);
    }
    
    /**
     * LÖscht den Schüler mit der ID $id
     * 
     * @param int $id
     */
    function deleteStudent($id) {
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Verbindung zur Datenbank konnte nicht hergestellt werden');
        $query = "DELETE FROM schueler WHERE id = '$id'";
        mysqli_query($link, $query) or die('MySQL Fehler: ' . mysqli_error($link));
        mysqli_close($link);
    }