<?php

require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/AdminPostManager.php');
require_once('model/AdminCommentManager.php');

function isAdmin(){
    if(!isset ($_SESSION['admin'])){
        if(isset($_POST['password']) && $_POST['password'] == "pass"){
            $_SESSION['admin'] = true;
            $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
            header('Location: index.php?action=admin');
        } else {
            throw new Exception('Cette page est réservé à l\'administrateur.');
        }
    }
}

function admin(){

    $postManager = new \OpenClassrooms\oc_project_4\Model\PostManager();
    $posts = $postManager->getPostsSample();
    $adminCommentManager = new \OpenClassrooms\oc_project_4\Model\AdminCommentManager();
    $nbReport = $adminCommentManager->countReport();

    require('view/backend/adminView.php');
}

function uploadImages(){


    if (isset($_POST['submit'])) {
        $countfiles = count($_FILES['myfile']['name']);
        for($i=0;$i<$countfiles;$i++){

            $currentDir = getcwd();
            $uploadDirectory = "/public/uploads/";
            $errors = []; // Store all foreseen and unforseen errors here

            $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions

            $fileName = $_FILES['myfile']['name'][$i];
            $fileSize = $_FILES['myfile']['size'][$i];
            $fileTmpName  = $_FILES['myfile']['tmp_name'];
            $fileType = $_FILES['myfile']['type'];
            $explodeFile = explode('.',$fileName);
            $fileExtension = strtolower(end($explodeFile));

            $uploadPath = $currentDir . $uploadDirectory . basename($fileName);


            if (! in_array($fileExtension,$fileExtensions)) {
                $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
            }
            if ($fileSize > 20000000) {
                $errors[] = "This file is more than 20MB. Sorry, it has to be less than or equal to 20MB";
            }
            if (empty($errors)) {
                $didUpload = move_uploaded_file($fileTmpName[$i], $uploadPath);

                if ($didUpload) {
                    $_SESSION['msg'] = "L'image " . basename($fileName) . " a été importée avec succès !";
                    echo '<script language="Javascript">document.location.replace("index.php?action=admin");</script>';
                } else {
                    echo "An error occurred somewhere. Try again or contact the admin";
                }
            } else {
                foreach ($errors as $error) {
                    echo $error . "These are the errors" . "\n";
                }
            }

        }
    }

}

function createPost($title, $content, $picture){
    $adminPostManager = new \OpenClassrooms\oc_project_4\Model\AdminPostManager();

    $newPost = $adminPostManager->createPost($title, $content, $picture);

    if (!isset ($newPost)) {
        throw new Exception('Impossible d\'ajouter le nouveau post !');
    }
    else {
        $_SESSION['msg'] = "La news a été postée avec succès !";
        echo '<script language="Javascript">
                 document.location.replace("index.php?action=admin");
     </script>';
    }
}

function getPostToUpdate($id){
    $adminPostManager = new \OpenClassrooms\oc_project_4\Model\AdminPostManager();
    $postUpdate = $adminPostManager->getPostToUpdate($id);

    require('view/backend/updatePostView.php');
}


function updatePost($id, $title, $content, $picture){
    $adminPostManager = new \OpenClassrooms\oc_project_4\Model\AdminPostManager();
    $update = $adminPostManager->updatePost($id, $title, $content, $picture);

    if (!isset ($update)) {
        throw new Exception('Impossible de modifier le post !');
    }
    else {
        $_SESSION['msg'] = "La news a été modifiée avec succès !";
        echo '<script language="Javascript">
                 document.location.replace("index.php?action=admin");
     </script>';
    }
}

function deletePost($id){
    $adminPostManager = new \OpenClassrooms\oc_project_4\Model\AdminPostManager();
    $delete = $adminPostManager->deletePost($id);

    if (!isset ($delete)) {
        throw new Exception("Impossible d'effacer le post !");
    }
    else {
        $_SESSION['msg'] = "La news a été effacée avec succès !";
        echo '<script language="Javascript">
                 document.location.replace("index.php?action=admin");
     </script>';
    }
}

function deleteComment($commentId){
    $adminCommentManager = new \OpenClassrooms\oc_project_4\Model\AdminCommentManager();
    $deleteCom = $adminCommentManager->deleteComment($commentId);
    if (!isset ($deleteCom)) {
        throw new Exception("Impossible d'effacer le post !");
    }
    else {
        $_SESSION['msg'] = "Le commentaire a été effacée avec succès !";
        header('Location: index.php?action=reports');
    }
}

function getReportComments(){
    $adminCommentManager = new \OpenClassrooms\oc_project_4\Model\AdminCommentManager();
    $getReportCom = $adminCommentManager->getReportComments();
    if (!isset($getReportCom)) {
        throw new Exception("Impossible d'afficher la page !");
    } elseif($getReportCom == false){
        $_SESSION['msg'] = "Aucun commentaire n'a été signalé !";
    }

    require('view/backend/adminCommentaryView.php');
}

function cancelReport($commentId){
    $adminCommentManager = new \OpenClassrooms\oc_project_4\Model\AdminCommentManager();
    $report = $adminCommentManager->cancelReport($commentId);
    if (!isset ($report)) {
        throw new Exception("Impossible d'annuler le signalement !");
    }
    else {
        $_SESSION['msg'] = "Le commentaire a été épargné !";
        header('Location: index.php?action=reports');
    }
}

function moderateComment($commentId){
    $adminCommentManager = new \OpenClassrooms\oc_project_4\Model\AdminCommentManager();
    $mod = $adminCommentManager->moderateComment($commentId);
    if (!isset ($mod)) {
        throw new Exception("Impossible d'annuler le signalement !");
    }
    else {
        $_SESSION['msg'] = "Le commentaire a été modéré";
        header('Location: index.php?action=reports');
    }
}

function contactEmail($from, $name, $mesSubject, $contentMessage){
    $to = "bezinbrice@gmail.com";
    $subject = "Un message vous a été envoyé";
    $subject2 = "Copie de votre message";
    $message = htmlspecialchars($name) . " " . " a écrit sur le sujet :" . $mesSubject . "\n\n" . htmlspecialchars($contentMessage);
    $message2 = "Voici une copie de votre message " . htmlspecialchars($name) . "\n\n" . htmlspecialchars($contentMessage);

    $headers = "De la part de : " . htmlspecialchars($from);
    $headers2 = "Pour : " . $to;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    $_SESSION['msg'] = "Message envoyé. Merci à vous " . htmlspecialchars($name) . ", Nous vous répondrons dans les plus bref délais.";
    echo '<script language="Javascript">
                 document.location.replace("index.php?action=contactView");
     </script>';
}