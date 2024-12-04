<?php
//users edit

include('includes\config.php');
include('includes\database.php');
include('includes\functions.php');
secure();
include('includes\header.php');



if (isset($_POST['username'])) {
    if ($stm = $connect->prepare('UPDATE users SET username=?, email=?, admin=?, active=? WHERE id = ?')) {
        $stm->bind_param('ssssi', $_POST['username'], $_POST['email'], $_POST['admin'], $_POST['active'], $_GET['id']);
        
        if ($stm->execute()) {
            $stm->close();

            if (isset($_POST['password']) && !empty($_POST['password'])) {
                //set_message("the password was updated", true);
                if ($stm = $connect->prepare('UPDATE users SET password = ? WHERE id=?')) {
                    $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $stm->bind_param('si', $hashed, $_GET['id']);
                    $stm->execute();
                    $stm->close();  
                } else {
                    echo "Could not prepare password update statement: " . $connect->error; 
            }
        }

            set_message("Uspešno posodobljen uporabnik - " . $_POST['username'], false);
            header('Location: users.php');
            die();
        } else {
            echo 'Could not execute user update statement: ' . $stm->error; 
        }
    } else {
        echo 'Could not prepare user update statement: ' . $connect->error; 
    }
}

if (isset($_GET['id'])) {
    if ($stm = $connect->prepare('SELECT * from users WHERE id=?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();


        $result = $stm->get_result();
        $user = $result->fetch_assoc();

        if ($user) {

        


            ?>
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h1 class="display-1">Uredi uporabnika</h1>
                        <form method="post">

                            <!-- Username -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" id="username" name="username" class="form-control active" value="<?php echo $user['username']?>" />
                                <label class="form-label" for="username">Uporabniško ime</label>
                            </div>

                            <!-- Email -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control active" value="<?php echo $user['email']?>" />
                                <label class="form-label" for="email">Email naslov</label>
                            </div>

                            <!-- Password -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="password" name="password" class="form-control" />
                                <label class="form-label" for="password">Geslo</label>
                            </div>

                            <!-- Active  -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <select name="active" class="form-select" id="active">
                                    <option <?php echo ($user['active']) ? "selected" : ""; ?> value="1">Aktiven</option>
                                    <option <?php echo ($user['active']) ? "" : "selected"; ?> value="0">Neaktiven</option>
                                </select>
                            </div>
                            
                            <!-- Admin -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <select name="admin" class="form-select" id="admin">
                                    <option <?php echo ($user['admin']) ? "selected" : ""; ?> value="1">Skrbnik</option>
                                    <option <?php echo ($user['admin']) ? "" : "selected"; ?> value="0">Uporabnik</option>
                                </select>
                            </div>

                            <!-- Submit button -->
                            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Uredi/posodobi uporabnika </button>
                            <!-- Submit gumb z potrdilom, samo mi google stock uprasalnik ni vsec, to je se za zrihtat 
                            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block" onclick="return confirm('Ali ste prepričani, da želite posodobiti uporabnika?')">Uredi/posodobi uporabnika</button>-->  

                            <button data-mdb-ripple-init type="button" class="btn btn-danger btn-primary btn-block"  onclick="window.location.href='users.php'">Prekliči</button>



                        </form>

                    </div>
                </div>
            </div>




            <?php
        }
        $stm->close();
     
    } else {
        echo 'Could not prepare statement!';
    }

} else {
    echo "Niste izbrali uporabnika";
    die();
}

include('includes\footer.php');
?>