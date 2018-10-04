<?php
require_once 'startSettings.php';

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
// File Create
if(isset($_POST['fileName']) && $_POST['create'] == 'Create'){
    $name = $settings['dir'] . '/' . $_POST['fileName'] . '.txt';
    file_put_contents($name , '');
    $_SESSION['Create'] = 'File ' . $_POST['fileName'] . ' Created Sucessfull';
    header('Location: '.$settings['uri']);
}
// Text to file
if(isset($_POST['fileText']) && $_POST['create'] == 'Create'){
    file_put_contents($settings['dir'] .'/' .$_SESSION['file'], $_POST['fileText']);
    unset($_SESSION['file']);
    $_SESSION['Create'] = 'Text writed Sucessfull';
    header('Location: '.$settings['uri']);
}

// delete
// unlink($file);
// rmdir($folder);