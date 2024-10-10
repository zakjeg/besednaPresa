<?php

include('includes\config.php');
include('includes\database.php');
include('includes\functions.php');
secure();
include('includes\header.php');




if (isset($_POST['username'])) {
    if ($stm = $connect->prepare('UPDATE  users set username=?, email=?, active=? WHERE id = ?')) {
        $stm->bind_param('sssi', $_POST['username'], $_POST['email'],$_POST['active'], $_GET['id']);
        $stm->execute();

        $stm->close();

        if(isset($_POST['password'])){
            if($stm = $connect->prepare('UPDATE users set password = ? WHERE id=?')){
                $hashed = SHA1($_POST['password']);
                $stm->bind_param('si', $hashed,  $_GET['id']);
                $stm->execute();
                $stm->close();  
            }else{
                echo "Could not prepare password update statement";
            }
            
            set_message("Uspešno posodobljen uporabnik - " . $_GET['id']);
            header(header: 'Location: users.php');
            die();

    }else {
        echo 'Could not prepare user update statement!';
    }

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

                            <!-- Username input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" id="username" name="username" class="form-control active" value="<?php echo $user['username']?>" />
                                <label class="form-label" for="username">Uporabniško ime</label>
                            </div>

                            <!-- Email input -->
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control active" value="<?php echo $user['email']?>" />
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
                                    <option <?php echo ($user['active']) ? "selected" : ""; ?> value="1">Aktiven</option>
                                    <option <?php echo ($user['active']) ? "" : "selected"; ?> value="0">Neaktiven</option>
                                </select>
                            </div>

                            <!-- Submit button -->
                            <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Uredi/posodobi uporabnika </button>
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