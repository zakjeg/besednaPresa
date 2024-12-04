<?php

include('includes\config.php');
include('includes\database.php');
include('includes\functions.php');
secure();
require_admin();
include('includes\header.php');

if(isset($_GET['delete'])){

    

    if($stm = $connect-> prepare('DELETE FROM users WHERE id = ?')){
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        set_message("Uspešno zbrisan uporabnik - " . $_GET['delete'], false);
        header('Location: users.php');
        $stm->close(); 
        die();
        }else{
            echo 'Could not prepare statement!';
        } 
}


if ($stm = $connect->prepare('SELECT * FROM users ')) {
    $stm->execute();

    $result = $stm->get_result();

    //var_dump($result->num_rows);

    //die();
    if ($result->num_rows > 0) {

        ?>


        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h1 class="display-1">Upravljanje uporabnikov</h1>
                    <table class="table table-striped table-hover">
                        <tr>
                            <th></th>
                            <th>Uporabniško ime</th>
                            <th>E-naslov</th>
                            <th>Skrbnik</th>
                            <th>Status</th>
                            <th style="white-space: nowrap;">Uredi | Izbriši</th>
                        </tr>
                        <tr>
                        <?php while ($record = mysqli_fetch_assoc($result)) { 

                            $profilePicture = $record['profile_picture'] ? $record['profile_picture'] : 'default_profile_picture.png'; ?>
                            <!--<td><?php #echo $record['id']; ?></td>-->
                            <td>
                                <img src="uploads\profile_pictures\<?php echo $profilePicture; ?>" alt="Profile Picture"                                      style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">

                            </td>
                            <td><h5><?php echo $record['username']; ?></h5></td>
                            <td><?php echo $record['email']; ?></td>
                            <td><?php echo $record['admin']; ?></td>
                            <td><?php echo $record['active']; ?></td>
                            <td style="white-space: nowrap;"><a href="users_edit.php?id=<?php echo $record['id']; ?>">Uredi</a> | 
                            <a href="users.php?delete=<?php echo $record['id']; ?>">Izbriši</a></td>
                        </tr>

                        <?php } ?>
                    </table>
                    <button type="button" class="btn btn-warning me-5" data-mdb-ripple-init onclick="window.location.href='users_add.php'">Dodaj novega uporabnika</button>
                    <button data-mdb-ripple-init type="button" class="btn btn-danger me-5"  onclick="window.location.href='dashboard.php'">Nazaj na nadzorno ploščo</button>

                </div>
            </div>
        </div>




        <?php
    } else {
        echo 'No users found';
    }

    $stm->close();
} else {
    echo 'Could not prepare statement!';
}
include('includes\footer.php');
?>