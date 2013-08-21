<?php 
	/* function.inc.php */

    include "constant.inc.php";
	/**
	 * Generate a random salt in the crypt(3) standard Blowfish format.
	 *
	 * @param int $cost Cost parameter from 4 to 31.
	 *
	 * @throws Exception on invalid cost parameter.
	 * @return string A Blowfish hash salt for use in PHP's crypt()
	 */
	function blowfishSalt($cost = 13)
	{
	    if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
	        throw new Exception("cost parameter must be between 4 and 31");
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
	    $connection = mysql_connect(DB_HOST, DB_USER , DB_PASS)
	    or die("Verbindung zur Datenbank konnte nicht hergestellt werden");
	    mysql_select_db(DB_NAME) or die ("Datenbank konnte nicht ausgewählt werden");

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
	    $ret = mysql_query($query) Or die("MySQL Fehler: " . mysql_error());

	    while($data = mysql_fetch_assoc($ret)) $result[] = $data;

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
	    $connection = mysql_connect(DB_HOST, DB_USER , DB_PASS)
	    or die("Verbindung zur Datenbank konnte nicht hergestellt werden");
	    mysql_select_db(DB_NAME) or die ("Datenbank konnte nicht ausgewählt werden");

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
	    $ret = mysql_query($query) Or die("MySQL Fehler: " . mysql_error());

	    while($data = mysql_fetch_assoc($ret)) $result[] = $data;

	    return $result;
	}

	/**
	 * Überprüft für einen Benutzer, ob ein bestimmtes Recht vorhanden ist
	 *
	 * @param string $id 		rightID
	 * @param array $rights 	Array mit Benutzerrechten
	 *
	 * @return string 			Name der Berechtigung, sonst NULL
	 */
	function hasRight($id, $rights) {
		foreach($rights as $r) {
			if($r["rightID"] == $id && $r["hasRight"] == 1) $result = $r["rightName"];
		}
		return $result;
	}

	/**
	 * Gibt alle Benutzer zurück
	 *
	 * @return array Benutzer
	 */
	function getUsers() {
	    $connection = mysql_connect(DB_HOST, DB_USER , DB_PASS)
	    or die("Verbindung zur Datenbank konnte nicht hergestellt werden");
	    mysql_select_db(DB_NAME) or die ("Datenbank konnte nicht ausgewählt werden");
		$query = "SELECT * FROM accounts ORDER BY ID ASC";
		$ret = mysql_query($query) OR die("MySQL Fehler: " . mysql_error());
		while($data = mysql_fetch_assoc($ret)) $result[] = $data;

	    return $result;
	}
?>