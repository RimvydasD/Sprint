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
// Create Folder for files/folders
if(!file_exists($settings['dir'])){
    mkdir($settings['dir']);
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
<div class="UI">
    <!-- Logout Form -->
    <form class="logout" action="" method="post">
        <input type="submit" name="logout" value="LOGOUT">
    </form>
    <!-- Session unset -->
    <form class="session" action="" method="post">
        <input type="submit" name="session" value="Unset Session">
    </form>
</div>
<div class="fileManager">
    <!-- File Create Form -->
    <form class="fileCreate" action="file.php" method="post">
        <div> File Create </div>
        <input type="text" name="fileName" placeholder=" File name">
        <input type="submit" name="create" value="Create">
    </form>
    <!-- Folder Create Form -->
    <form class="folderCreate" action="file.php" method="post">
        <div> Folder Create </div>
        <input type="text" name="folderName" placeholder=" Folder name">
        <input type="submit" name="create" value="Create">
    </form>
    <!-- File upload -->
    <form class="fileUpload" action="file.php" method="post" enctype="multipart/form-data">
        <div> Select image to upload </div>
        <input type="file" name="fileToUpload">
        <input type="submit" name="submit" value="Upload Image">
    </form>
</div>
<div class="info">
<?php 
//  INFO Message
if (isset($_SESSION['Info'])){
    echo '<span>' .$_SESSION['Info'] .'</span>';
    unset($_SESSION['Info']);
}
?>
</div>
<div class="folderUI">
<?php
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
        <div>
            <?php echo 'Folder: ' .$_SESSION['dir']; ?>
        </div>
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
</div>
<div class="fileShow">
<?php
// Text Form Area 
if(isset($_GET['file']) && substr($_GET['file'], -4) == '.txt' ){
?>
    <form action="file.php" method="post">
        <div class="show">
            <p> File: <?php echo $_GET['file']; ?></p>
            <textarea name="fileText" placeholder=" Text write to file"><?php 
                if(isset($_GET['file'])) {
                    $_SESSION['file']=$_GET['file'];
                    }
                echo file_get_contents($settings['dir'].$_SESSION['dir'].'/'.$_SESSION['file'])
            ?></textarea>
        </div>
        <div class="buttons">
            <input type="submit" name="delete" value="Delete">
            <input type="submit" name="save" value="Save">
        </div>
    </form>
<?php
// Jpg Show Area
}else if (isset($_GET['file']) && substr($_GET['file'], -4) == '.jpg' ){
    if(isset($_GET['file'])) {
        $_SESSION['file'] = $_GET['file'];
        }
?>        
    <form action="file.php" method="post">
        <div> File: <?php echo $_GET['file']; ?> </div>
<?php       
        echo '<img src="'.$settings['dir'].$_SESSION['dir'].'/'.$_SESSION['file'] . '">';
?>
        <input type="submit" name="delete" value="Delete">
    </form>  
<?php  
}
?>
</div>

</body>
</html>