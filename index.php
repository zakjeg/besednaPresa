<?php
//index.php
include('includes\config.php');
include('includes\database.php');
include('includes\functions.php');

if(isset($_SESSION['id'])){
    header('Location: dashboard.php');
    die();
}

include('includes\header.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        set_message("Prosim izpolnite polja E-poštni naslov in Geslo", true);
    } else {
        if ($stm = $connect->prepare('SELECT id, username, password, admin FROM users WHERE email = ? AND active = 1')) {
            $stm->bind_param('s', $email);
            $stm->execute();
            $result = $stm->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true); // Prevent session fixation attacks
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['admin'];

                set_message("Uspešna prijava " . $_SESSION['username'], false);
                header('Location: dashboard.php');
                die();
            } else {
                set_message('Neveljaven E-poštni naslov ali Geslo', true);
            }

            $stm->close();
        } else {
            error_log('Could not prepare statement!');
            set_message('Something went wrong. Please try again later.', true);
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