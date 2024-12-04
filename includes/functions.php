<?php

include "database.php";
//functions.php
//$connect = mysqli_connect('localhost', 'cms', 'geslo', 'cms');
$connect = mysqli_connect($hostname, $username, $password, $database);

if(mysqli_connect_errno()){
    exit('failed to connect to mySQL : ' . mysqli_connect_error());
}

function secure(){
    if(!isset($_SESSION['id'])){
        set_message("Za dostop se morate prijaviti!", true);
        header('Location: /cms');
        die();
    }
}

function require_admin(){
    if(!isset($_SESSION['is_admin']) || $_SESSION['is_admin']!=1){
        set_message("Urejanje uporabnikov je na voljo le za administratorje", true);
        header('Location: dashboard.php');
        die();
    }
}

function set_message($message, $isError){
    $_SESSION['message'] = $message;
    $_SESSION['isError'] = $isError;
}

function get_message(){
    if(isset($_SESSION['message']) && isset($_SESSION['isError'])){
        if($_SESSION['isError']){
            echo "<script type='text/javascript'> showToast('" . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . "','top right','error') </script>";}     

        echo "<script type='text/javascript'> showToast('" . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . "','top right','success') </script>";
    }
    unset($_SESSION['message']);
    unset($_SESSION['isError']);
}

?>

 