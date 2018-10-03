<?php
require_once 'startSettings.php';

// paspaustas mygtukas LOGIN
if(isset($_POST['login'])) {
    if ($_POST['username'] == $settings['name'] && $_POST['password'] == $settings['password']) {
        $_SESSION['login'] = 1;
    }
}
// tikriname sesijoje 
if (isset($_SESSION['login']) && $_SESSION['login'] == 1) {
    header('Location: '.$settings['uri']);
    die();
}

?>

<?php 
if (isset($_POST['login']) && (!isset($_SESSION['login']) || $_SESSION['login'] != 1)) {
    echo 'Error!';
}

?>
<h3>Files Manager Login</h3>
<form action="" method="post">
<p>Name:<p> <input type="text" name="username">
<p>Pasword:<p> <input type="password" name="password">
<input type="submit" name="login" value="LOGIN">
</form>