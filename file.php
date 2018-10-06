<?php
require_once 'startSettings.php';

$settings['dir'] = $settings['dir'].$_SESSION['dir'];
// Back Folder
if(isset($_POST['Back'])){
    $patern = '/([^\/]*)$/';
    preg_match($patern, $_SESSION['dir'], $match, 0);
    $_SESSION['dir'] = substr($_SESSION['dir'], 0, -(strlen($match[0])+1));
    header('Location: '.$settings['uri']);
}
// File Create
if(isset($_POST['fileName']) && isset($_POST['create'])){
    $name = $settings['dir'] . '/' . $_POST['fileName'] . '.txt';
    file_put_contents($name , '');
    $_SESSION['Info'] = 'File ' . $_POST['fileName'] . ' Created Sucessfull';
    header('Location: '.$settings['uri'].'?file='.$_POST['fileName'].'.txt');
}
// Folder Create
if(isset($_POST['folderName']) && isset($_POST['create'])){
    if(!file_exists($settings['path'] . '/' . $settings['dir'] . '/' . $_POST['folderName'])){
        mkdir($settings['path'] . '/' . $settings['dir'] . '/' . $_POST['folderName']);
        $_SESSION['Info'] = 'Folder ' . $_POST['folderName'] . ' Created Sucessfull';
        header('Location: '.$settings['uri']);
    }else{
        $_SESSION['Info'] = 'Folder failed to create';
        header('Location: '.$settings['uri']);
    }
}
// Text to file
if(isset($_POST['fileText']) && isset($_POST['save'])){
    file_put_contents($settings['dir'] .'/' .$_SESSION['file'], $_POST['fileText']);
    unset($_SESSION['file']);
    $_SESSION['Info'] = 'Text saved Sucessfull';
    header('Location: '.$settings['uri']);
}
// Delete file or jpg
if(isset($_SESSION['file']) && isset($_POST['delete'])){
    unlink($settings['dir'] .'/' .$_SESSION['file']);
    $_SESSION['Info'] = $_SESSION['file'].' Deleted Sucessfull';
    unset($_SESSION['file']);
    header('Location: '.$settings['uri']);
}

// rmdir($folder); deletes folder

// File Upload
if(isset($_FILES['fileToUpload']) && isset($_POST['submit'])){
    $file = $settings['dir'] .'/' .basename($_FILES['fileToUpload']['name']);
    $filetype = $_FILES["fileToUpload"]["type"];

    if(!file_exists($file) && $filetype == 'image/jpeg'){
        move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file);
        $_SESSION['Info'] = 'The File ' .basename($_FILES['fileToUpload']['name']) . ' has been uploaded';
        header('Location: '.$settings['uri']);
    }else{
        $_SESSION['Info'] = 'The File ' .basename($_FILES['fileToUpload']['name']) . ' failed to upload';
        header('Location: '.$settings['uri']);
    }
}
