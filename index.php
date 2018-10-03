
<?php
require_once 'startSettings.php';
if (isset($_POST['logout']) && $_POST['logout'] == 'LOGOUT'){
    $_SESSION['login'] = 0;
}
// tikriname sesijoje 
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('Location: '.$settings['uri'].'login.php');
    die();
}
?>
<!-- Logout Forma -->
<form action="" method="post" style="float:right">
    <input type="submit" name="logout" value="LOGOUT">
</form>


<?php 
if (isset($_SESSION['Create'])){
    echo $_SESSION['Create'];
    unset($_SESSION['Create']);
}
?>

<!-- File Create Forma -->
<form action="file.php" method="post">
    <input type="text" name="fileName" placeholder=" File name">
    <input type="submit" name="create" value="Create">
</form>
<!-- Folder Create Forma -->
<form action="file.php" method="post">
    <input type="text" name="folderName" placeholder=" Folder name">
    <input type="submit" name="create" value="Create">
</form>


<!-- $file = 'test.txt' ;
file_put_contents($file, '');
$homepage = file_get_contents($file);
echo $homepage;

unlink($file); -->