<?php
require_once 'startSettings.php';
// Create Folder for files/folders
if(!file_exists($settings['dir'])){
    mkdir($settings['dir']);
}
// Logout
if (isset($_POST['logout']) && $_POST['logout'] == 'LOGOUT'){
    $_SESSION['login'] = 0;
}
// tikriname sesijoje 
if (!isset($_SESSION['login']) || $_SESSION['login'] != 1) {
    header('Location: '.$settings['uri'].'login.php');
    die();
}
// Session unset
if(isset($_POST['session'])){
    session_unset();
    header('Location: '.$settings['uri']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>
    <link href="index.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<!-- Logout Form -->
<form action="" method="post" style="float:right">
    <input type="submit" name="logout" value="LOGOUT">
</form>
<!-- Session unset -->
<form action="" method="post" style="float:right">
    <input type="submit" name="session" value="Unset Session">
</form>

<?php 
//  INFO Message
if (isset($_SESSION['Create'])){
    echo $_SESSION['Create'];
    unset($_SESSION['Create']);
}
?>

<!-- File Create Form -->
<form action="file.php" method="post">
    <input type="text" name="fileName" placeholder=" File name">
    <input type="submit" name="create" value="Create">
</form>
<!-- Folder Create Form -->
<form action="file.php" method="post">
    <input type="text" name="folderName" placeholder=" Folder name">
    <input type="submit" name="create" value="Create">
</form>
<!-- Text Area Form -->
<?php
if(isset($_GET['file']) && substr($_GET['file'], -4) == '.txt' ){
?>
    <form action="file.php" method="post" style="float:right">
        <p> File: <?php echo $_GET['file']; ?> </p>
        <textarea name="fileText" placeholder=" Text write to file"><?php 
            if(isset($_GET['file'])) {
                $_SESSION['file']=$_GET['file'];
                }
            echo file_get_contents($settings['dir'].$_SESSION['dir'].'/'.$_SESSION['file'])
        ?></textarea>
        <input type="submit" name="delete" value="Delete">
        <input type="submit" name="create" value="Create">
    </form>
<?php
// Jpg Show Area
}else if (isset($_GET['file']) && substr($_GET['file'], -4) == '.jpg' ){
    if(isset($_GET['file'])) {
        $_SESSION['file'] = $_GET['file'];
        }
?>        
    <form action="file.php" method="post" style="float:right">
        <p> File: <?php echo $_GET['file']; ?> </p>
<?php       
        echo '<img src="'.$settings['dir'].'/'.$_SESSION['file'] . '" style="height: 150px;width: 150px;"/>';
?>
        <input type="submit" name="delete" value="Delete">
    </form>  
<?php  
}
// Whats in Folder show
if(!isset($_SESSION['dir'])){
    $_SESSION['dir'] = "";
}
if(isset($_GET['folder'])){
    $_SESSION['dir'] = $_SESSION['dir'].'/'.$_GET['folder'];
}
if($_SESSION['dir'] != ""){
?>
    <form action="file.php" method="post">
        <input type="submit" name="Back" value="Back">
    </form> 
<?php
}
if ($handle = opendir($settings['dir'].$_SESSION['dir'])) {
   while (false !== ($entry = readdir($handle))) {
       if($entry !="." && $entry !=".."){
           if(!is_dir($settings['dir'].$_SESSION['dir'].'/'.$entry)){
               echo '<a href="?file='.$entry . '">'.$entry.'</a><br>';
            }else{
                echo '<a href="?folder='.$entry .'">'.$entry.'</a><br>';
           }
       }
   }
   closedir($handle);
}
?>
<!-- File upload -->
<form action="file.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileSelect">
    <input type="submit" name="submit" value="Upload Image">
</form>


</body>
</html>