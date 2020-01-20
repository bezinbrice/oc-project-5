<?php
require('controller/frontend.php');
require('controller/backend.php');
session_start();
try {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case('listPosts'):
                $nb_posts_page= 5;
                $nb_posts = totalPosts();
                $nb_page = ceil($nb_posts/$nb_posts_page);

                if (isset ($_GET['page'])) {
                    $actualPage=intval($_GET['page']);
                    if ($actualPage>=$nb_page) {
                        $actualPage=$nb_page;
                    }
                    listPosts($actualPage,$nb_posts_page, $nb_page);
                } else {
                    $actualPage=1;
                    listPosts($actualPage, $nb_posts_page, $nb_page);
                }
                break;

            case('post'):
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    post();
                } else {
                    throw new Exception('aucun identifiant de billet envoyé');
                }
                break;

            case('addComment'):
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                        addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                    } else {
                        throw new Exception('Tous les champs ne sont pas remplis !');
                    }
                } else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
                break;

            case('report'):
                    report($_GET['comment_id'], $_GET['post_id']);
                    if(isset($_SESSION['admin']) && isset($_POST['deleteComment'])){
                        deleteComment($_GET['comment_id']);
                    } elseif(isset($_SESSION['admin']) && isset($_POST['cancelReport'])){
                        cancelReport($_GET['comment_id']);
                    } elseif(isset($_SESSION['admin']) && isset($_POST['moderateComment'])){
                        moderateComment($_GET['comment_id']);
                    }
                break;

            case('admin'):
                    if(!isset($_SESSION['admin'])) {
                        isAdmin();
                    } elseif(isset($_SESSION['admin'])){
                            if(!isset($_GET['edit'])){
                                admin();
                                if(isset($_POST['save'])) {
                                    if (!empty($_POST['title']) && !empty($_POST['content']) &&!empty($_POST['pictureName'])) {
                                        createPost($_POST['title'], $_POST['content'], $_POST['pictureName']);
                                    } else {
                                        throw new Exception('Tous les champs ne sont pas remplis !');
                                    }
                                }
                            } elseif (isset($_GET['edit'])){
                                getPostToUpdate($_GET['edit']);
                                if (isset($_POST['update'])) {
                                    if (!empty($_POST['title']) && !empty($_POST['content'])) {
                                        updatePost($_GET['edit'],$_POST['title'], $_POST['content']);
                                    }
                                    else {
                                        throw new Exception('Tous les champs ne sont pas remplis !');
                                    }
                                }  elseif (isset($_POST['delete'])){
                                    deletePost($_GET['edit']);
                                    throw new Exception('Tous les champs ne sont pas remplis !');
                                }
                            }
                        } else {
                        throw new Exception('Espace réservé à l\'administrateur');
                    }
                break;
            case('reports'):
                if(isset($_SESSION['admin'])){
                    getReportComments();
                }
                else{
                    throw new Exception('Espace réservé à l\'administrateur');
                }
                break;

            case('fileUpload'):
                $currentDir = getcwd();
                $uploadDirectory = "/uploads/";

                $errors = []; // Store all foreseen and unforseen errors here

                $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions

                $fileName = $_FILES['myfile']['name'];
                $fileSize = $_FILES['myfile']['size'];
                $fileTmpName  = $_FILES['myfile']['tmp_name'];
                $fileType = $_FILES['myfile']['type'];
                $explodeFile = explode('.',$fileName);
                $fileExtension = strtolower(end($explodeFile));

                $uploadPath = $currentDir . $uploadDirectory . basename($fileName);

                echo $uploadPath;

                if (isset($_POST['submit'])) {

                    if (! in_array($fileExtension,$fileExtensions)) {
                        $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
                    }

                    if ($fileSize > 20000000) {
                        $errors[] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
                    }

                    if (empty($errors)) {
                        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

                        if ($didUpload) {
                            echo "The file " . basename($fileName) . " has been uploaded";
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
    elseif(isset($_GET['logout'])){
        unset ($_SESSION['admin']);
        home();
    }
    else {
        home();
    }
}

catch(Exception $e){
    $errorMessage = $e->getMessage();
    require('view/frontend/errorView.php');
}
