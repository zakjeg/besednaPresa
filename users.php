<?php

include('includes\config.php');
include('includes\database.php');
include('includes\functions.php');
secure();
include('includes\header.php');

if(isset($_GET['delete'])){
    if($stm = $connect-> prepare('DELETE FROM users WHERE id = ?')){
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        set_message("Uspešno zbrisan uporabnik - " . $_GET['delete']);
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
                            <th>Id</th>
                            <th>Uporabniško ime</th>
                            <th>E-naslov</th>
                            <th>Status</th>
                            <th>Uredi | Izbriši</th>
                        </tr>
                        <tr>
                        <?php while ($record = mysqli_fetch_assoc($result)) { ?>
                            <td><?php echo $record['id']; ?></td>
                            <td><?php echo $record['username']; ?></td>
                            <td><?php echo $record['email']; ?></td>
                            <td><?php echo $record['active']; ?></td>
                            <td><a href="users_edit.php?id=<?php echo $record['id']; ?>">Uredi</a> | 
                            <a href="users.php?delete=<?php echo $record['id']; ?>">Izbriši</a></td>
                        </tr>

                        <?php } ?>
                    </table>
                    <button type="button" class="btn btn-warning me-5" data-mdb-ripple-init onclick="window.location.href='users_add.php'">Dodaj novega uporabnika</button>
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