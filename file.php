<?php
require_once 'startSettings.php';

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

// delete
// rmdir($folder);

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


// // Check if the form was submitted
// if($_SERVER["REQUEST_METHOD"] == "POST"){
//     // Check if file was uploaded without errors
//     if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
//         $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
//         $filename = $_FILES["photo"]["name"];
//         $filetype = $_FILES["photo"]["type"];
//         $filesize = $_FILES["photo"]["size"];
    
//         // Verify file extension
//         $ext = pathinfo($filename, PATHINFO_EXTENSION);
//         if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    
//         // Verify file size - 5MB maximum
//         $maxsize = 5 * 1024 * 1024;
//         if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
    
//         // Verify MYME type of the file
//         if(in_array($filetype, $allowed)){
//             // Check whether file exists before uploading it
//             if(file_exists("work/" . $filename)){
//                 echo $filename . " is already exists.";
//             } else{
//                 move_uploaded_file($_FILES["photo"]["tmp_name"], "work/" . $filename);
//                 echo "Your file was uploaded successfully.";
//             } 
//         } else{
//             echo "Error: There was a problem uploading your file. Please try again."; 
//         }
//     } else{
//         echo "Error: " . $_FILES["photo"]["error"];
//     }
// }