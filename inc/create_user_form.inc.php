<?php

// Create_User form

?>

<form class="admin" action="./inc/create_user.inc.php" method="POST">
    <h1>Benutzer anlegen</h1>
    <fieldset id="inputs">
    	<label>Email:</label>
        <input id="email" type="text" name="email" placeholder="eMail" autofocus required>
    </fieldset>   
    <fieldset id="inputs">
    	<label>Passwort:</label>
        <input id="password" type="password" name="password" placeholder="Passwort" required>

    	<label>Passwort wiederholen:</label>
        <input id="passwordConfirmation" type="password" name="passwordConfirmation" placeholder="Passwort wiederholen" required>
    </fieldset>
    <fieldset id="actions">
        <input type="submit" id="submit" value="Anlegen">
    </fieldset>
</form>