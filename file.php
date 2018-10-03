<?php
require_once 'startSettings.php';


if(isset($_POST['folderName']) && $_POST['create'] == 'Create'){
    if(!file_exists($settings['dir'].'\/work/'.$_POST['folderName'])){
        mkdir($settings['dir'].'\/work/'.$_POST['folderName']);
        $_SESSION['Create'] = 'Folder ' . $_POST['folderName'] . ' Created Sucessfull';
        header('Location: '.$settings['uri']);
    }else{
        $_SESSION['Create'] = 'Folder failed to create';
        header('Location: '.$settings['uri']);
    }
}
if(isset($_POST['fileName']) && $_POST['create'] == 'Create'){
    $name = $_POST['fileName'] . '.txt';
    file_put_contents($name, '');
    $_SESSION['Create'] = 'File ' . $_POST['fileName'] . ' Created Sucessfull';
    header('Location: '.$settings['uri']);
}

// delete
// unlink($file);
// rmdir($folder);