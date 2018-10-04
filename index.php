
<?php
require_once 'startSettings.php';
// Logout
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
//  INFO Message
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
<!-- Text Area Forma -->
<?php
if(isset($_GET['file']) && substr($_GET['file'], -4) == '.txt' ){
?>
    <form action="file.php" method="post" style="float:right">
        <textarea name="fileText" placeholder=" Text write to file"><?php 
            if(isset($_GET['file'])) {
                $_SESSION['file']=$_GET['file'];
                }
            echo file_get_contents('work/'.$_SESSION['file'])
        ?></textarea>
        <input type="submit" name="delete" value="Delete">
        <input type="submit" name="create" value="Create">
    </form>
<?php
// Jpg Show Area
}else if (isset($_GET['file']) && substr($_GET['file'], -4) == '.jpg' ){
    if(isset($_GET['file'])) {
        $_SESSION['file']=$_GET['file'];
        }
?>        
    <form action="file.php" method="post" style="float:right">
<?php       
        echo '<img src="'.$settings['dir'].'/'.$_SESSION['file'] . '" style="height: 150px;width: 150px;"/>';
?>
        <input type="submit" name="delete" value="Delete">
    </form>  
<?php  
}
?>

<!-- Whats in Folder show -->
<?php
if ($handle = opendir('work')) {
   while (false !== ($entry = readdir($handle))) {
       if($entry !="." && $entry !=".."){
           echo '<a href="?file='.$entry . '">'.$entry.'<br>';
       }
   }
   closedir($handle);
}
?>
<br>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" name="submit" value="Upload Image">
</form>


