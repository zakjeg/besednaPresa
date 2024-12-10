<?php

include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();
include('includes/header.php');

if(isset($_GET['delete'])){
    if($stm = $connect-> prepare('DELETE FROM posts WHERE id = ?')){
        $stm->bind_param('i', $_GET['delete']);
        $stm->execute();

        set_message("Uspešno zbrisan post - " . $_GET['delete'], false);
        header('Location: posts.php');
        $stm->close(); 
        die();
        }else{
            echo 'Could not prepare statement!';
        } 
}

if ($stm = $connect->prepare('SELECT * FROM posts')) {
    $stm->execute();
    $result = $stm->get_result();

    ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <h1 class="display-1">Urejanje člankov</h1>
                <?php if ($result->num_rows > 0) { ?>
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>Id</th>
                            <th>Naslov</th>
                            <th>Avtor Id</th>
                            <th>Vsebina</th>
                            <th>Datum</th>
                            <th>Uredi | Izbriši</th>
                        </tr>
                        <tr>
                        <?php while ($record = mysqli_fetch_assoc($result)) { ?>
                            <td><?php echo $record['id']; ?></td>
                            <td><?php echo $record['title']; ?></td>
                            <td><?php echo $record['author']; ?></td>
                            <td><?php echo $record['content']; ?></td>
                            <td><?php echo $record['date']; ?></td>
                            <td>
                                <a href="posts_edit.php?id=<?php echo $record['id']; ?>">Uredi</a> | 
                                <a href="posts.php?delete=<?php echo $record['id']; ?>">Izbriši</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <p class="text-center mt-3">No posts found</p>
                <?php } ?>
                <!-- Always display the buttons -->
                <button type="button" class="btn btn-warning me-5" data-mdb-ripple-init onclick="window.location.href='posts_add.php'">Dodaj nov članek</button>
                <button data-mdb-ripple-init type="button" class="btn btn-danger me-5" onclick="window.location.href='dashboard.php'">Nazaj na nadzorno ploščo</button>
            </div>
        </div>
    </div>
    <?php
    $stm->close();
} else {
    echo 'Could not prepare statement!';
}
include('includes/footer.php');