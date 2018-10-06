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
if(isset($_POST['fileName']) && $_POST['create'] == 'Create'){
    $name = $settings['dir'] . '/' . $_POST['fileName'] . '.txt';
    file_put_contents($name , '');
    $_SESSION['Create'] = 'File ' . $_POST['fileName'] . ' Created Sucessfull';
    header('Location: '.$settings['uri'].'?file='.$_POST['fileName'].'.txt');
}
// Folder Create
if(isset($_POST['folderName']) && $_POST['create'] == 'Create'){
    if(!file_exists($settings['path'] . '/' . $settings['dir'] . '/' . $_POST['folderName'])){
        mkdir($settings['path'] . '/' . $settings['dir'] . '/' . $_POST['folderName']);
        $_SESSION['Create'] = 'Folder ' . $_POST['folderName'] . ' Created Sucessfull';
        header('Location: '.$settings['uri']);
    }else{
        $_SESSION['Create'] = 'Folder failed to create';
        header('Location: '.$settings['uri']);
    }
}
// Text to file
if(isset($_POST['fileText']) && $_POST['create'] == 'Create'){
    file_put_contents($settings['dir'] .'/' .$_SESSION['file'], $_POST['fileText']);
    unset($_SESSION['file']);
    $_SESSION['Create'] = 'Text writed Sucessfull';
    header('Location: '.$settings['uri']);
}
// Delete file or jpg
if(isset($_SESSION['file']) && $_POST['delete'] == 'Delete'){
    unlink($settings['dir'] .'/' .$_SESSION['file']);
    $_SESSION['Create'] = $_SESSION['file'].' Deleted Sucessfull';
    unset($_SESSION['file']);
    header('Location: '.$settings['uri']);
}

// rmdir($folder); deletes folder

// File Upload
if(isset($_FILES['fileToUpload']) && $_POST['submit'] == 'Upload Image'){
    $file = $settings['dir'] .'/' .basename($_FILES['fileToUpload']['name']);
    $filetype = $_FILES["fileToUpload"]["type"];

    if(!file_exists($file) && $filetype == 'image/jpeg'){
        move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file);
        $_SESSION['Create'] = 'The File ' .basename($_FILES['fileToUpload']['name']) . ' has been uploaded';
        header('Location: '.$settings['uri']);
    }else{
        $_SESSION['Create'] = 'The File ' .basename($_FILES['fileToUpload']['name']) . ' failed to upload';
        header('Location: '.$settings['uri']);
    }
}
