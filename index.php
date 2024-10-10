<?php

include('includes\config.php');
include('includes\database.php');
include('includes\functions.php');
if(isset($_SESSION['id'])){
    header('Location: dashboard.php');
    die();
}

include('includes\header.php');


/*
if(isset($_POST['email'])){
    if($stm = $connect-> prepare('SELECT * FROM users WHERE email = ? AND password = ? AND active = 1')){
        $hashed = SHA1($_POST['password']);
        $stm->bind_param('ss', $_POST['email'], $hashed);
        $stm->execute();

        $result = $stm->get_result();
        $user = $result->fetch_assoc();

        if($user){
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];

            set_message("Succesful loign " . $_SESSION['username']);
            header('Location: dashboard.php');
            die();
        }else{
            echo 'Could not prepare statement!';
        }
        $stm->close();
    
    }
}
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if both email and password are provided
    if (empty($email) || empty($password)) {
        set_message("Prosim izpolnite polja E-poštni naslov in Geslo ",);
    } else {
        // Proceed with preparing and executing the SQL statement
        if($stm = $connect->prepare('SELECT * FROM users WHERE email = ? AND password = ? AND active = 1')){
            $hashed = SHA1($password);
            $stm->bind_param('ss', $email, $hashed);
            $stm->execute();

            $result = $stm->get_result();
            $user = $result->fetch_assoc();

            if($user){
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];

                set_message("Uspešna prijava " . $_SESSION['username']);
                header('Location: dashboard.php');
                die();
            } else {
                set_message('Neveljaven E-poštni naslov ali Geslo');
            }

            $stm->close();
        } else {
            echo 'Could not prepare statement!';
        }
    }
}


?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method = "post">

                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="email" id="email" name="email" class="form-control" />
                    <label class="form-label" for="email">E-poštni naslov</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" />
                    <label class="form-label" for="password">Geslo</label>  
                </div>



                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Prijava</button>
            </form>

        </div>
    </div>
</div>




<?php
include('includes\footer.php');
?>