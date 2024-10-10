<?php
$connect = mysqli_connect('localhost', 'cms', 'geslo', 'cms');

if(mysqli_connect_errno()){
    exit('failed to connect to mySQL : ' . mysqli_connect_error());
}

function secure(){
    if(!isset($_SESSION['id'])){
        set_message("Please login first to view page.");
        header('Location: /cms');
        die();
    }
}

function set_message($message){
    $_SESSION['message'] = $message;
}

function get_message(){
    if(isset($_SESSION['message'])){
        echo '<p>' . $_SESSION['message'] . '</p> <hr>';

    }
    unset($_SESSION['message']); 
}

?>

 