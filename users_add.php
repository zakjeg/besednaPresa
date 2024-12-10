<?php

include('includes\config.php');
include('includes\database.php');
include('includes\functions.php');
secure();
include('includes\header.php');

if (isset($_POST['username'])) {
    // Check if email already exists
    if ($stm = $connect->prepare('SELECT COUNT(*) FROM users WHERE email = ?')) {
        $stm->bind_param('s', $_POST['email']);
        $stm->execute();
        $stm->bind_result($count);
        $stm->fetch();
        $stm->close();

        if ($count > 0) {
            set_message("Email že obstaja. Prosimo, uporabite drugega.", true);
        } else {
            $profile_picture = NULL; // Default value if no file is uploaded

            // Handle file upload only if a file is selected
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                $img_name = $_FILES['profile_picture']['name'];
                $img_size = $_FILES['profile_picture']['size'];
                $tmp_name = $_FILES['profile_picture']['tmp_name'];

                if ($img_size > 125000) {
                    set_message("Datoteka je prevelika.", true);
                } else {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
                    $allowed_exs = array("jpg", "jpeg", "png");

                    if (in_array($img_ex_lc, $allowed_exs)) {
                        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                        $img_upload_path = 'uploads\\profile_pictures\\' . $new_img_name;

                        // Ensure the directory exists
                        if (!is_dir('uploads\\profile_pictures\\')) {
                            mkdir('uploads\\profile_pictures\\', 0777, true);
                        }

                        // Move file and check result
                        if (move_uploaded_file($tmp_name, $img_upload_path)) {
                            $profile_picture = $new_img_name;  // Store the new image name
                        } else {
                            set_message("Napaka pri nalaganju datoteke.", true);
                        }
                    } else {
                        set_message("Neveljavna vrsta datoteke.", true);
                    }
                }
            }

            // Insert user into database with or without profile picture
            if ($stm = $connect->prepare('INSERT INTO users (username, email, password, admin, active, profile_picture) VALUES (?, ?, ?, ?, ?, ?)')) {
                $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $stm->bind_param(
                    'ssssss',
                    $_POST['username'],
                    $_POST['email'],
                    $hashed,
                    $_POST['admin'],
                    $_POST['active'],
                    $profile_picture // This will be NULL if no image was uploaded
                );

                if ($stm->execute()) {
                    set_message("Uspešno dodan nov uporabnik - " . $_POST['username'], false);
                    header('Location: users.php');
                    exit;
                } else {
                    set_message("Napaka pri shranjevanju uporabnika.", true);
                }
                $stm->close();
            } else {
                error_log("SQL Prepare Error: " . $connect->error);
                echo 'Could not prepare statement!';
            }
        }
    } else {
        echo 'Could not prepare statement!';
    }
}

?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="display-1">Dodaj uporabnika</h1>
            <form method="post" enctype="multipart/form-data">
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

                <!-- Admin select -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <select name="admin" class="form-select" id="admin">
                        <option value="1">Skrbnik</option>
                        <option value="0">Uporabnik</option>
                    </select>
                </div>

                <!-- Profile Picture Upload -->
                 
                <!--
                <div data-mdb-input-init class="form-outline mb-4">
                    <p>Profilna slika uporabnika</p>
                    <input type="file" name="profile_picture" id="profile_picture">
                </div> -->

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Add user</button>
            </form>
        </div>
    </div>
</div>

<?php
include('includes\footer.php');
?>
