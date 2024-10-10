<?php

include('includes\config.php');
include('includes\database.php');
include('includes\functions.php');
secure();
include('includes\header.php');

if(isset($_POST['username'])){
    if($stm = $connect-> prepare('INSERT INTO users (username, email, password, active) VALUES (?,?,?,?)')){
        $hashed = SHA1($_POST['password']);
        $stm->bind_param('ssss', $_POST['username'],$_POST['email'],$hashed, $_POST['active']);
        $stm->execute();

        set_message("Uspešno dodan nov uporabnik - " . $_SESSION['username']);
        header('Location: users.php');
        $stm->close(); 
        die();
        }else{
            echo 'Could not prepare statement!';
        }
        
    
}


?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Dodaj uporabnika</h1>
            <form method="post">

                <!-- Username input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control" />
                    <label class="form-label" for="username">Uporabniško ime</label>
                </div>

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">Email naslov</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Geslo</label>
                </div>

                <!-- Active select -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <select name="active" class="form-select" id="active">
                        <option value="1">Aktiven</option>
                        <option value="0">Neaktiven</option>
                    </select>   
                </div>

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Add user </button>
            </form>

        </div>
    </div>
</div>




<?php
include('includes\footer.php');
?>