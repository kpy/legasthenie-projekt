<?php

// login form

?>

<form id="login" action="./inc/login.inc.php" method="POST">
    <h1>Login</h1>
    <fieldset id="inputs">
        <input id="email" type="text" name="email" placeholder="eMail" autofocus required>   
        <input id="password" type="password" name="password" placeholder="Passwort" required>
    </fieldset>
    <fieldset id="actions">
        <input type="submit" id="submit" value="Login">
        <a href="">Passwort vergessen?</a>
    </fieldset>
</form>