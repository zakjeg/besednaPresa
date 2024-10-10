<?php

include('includes\config.php');
include('includes\database.php');
include('includes\functions.php');
secure();
include('includes\header.php');




if (isset($_POST['title'])) {
    if ($stm = $connect->prepare('UPDATE  posts set title=?, content=?, date=? WHERE id = ?')) {
        $stm->bind_param('sssi', $_POST['title'], $_POST['content'],$_POST['date'], $_GET['id']);
        $stm->execute();
        $stm->close();
        
        set_message("Uspešno objavljen članek - " . $_GET['id']);
        header(header: 'Location: posts.php');
        die();

    }else {
        echo 'Could not prepare user update statement!';
    }
}

if (isset($_GET['id'])) {
    if ($stm = $connect->prepare('SELECT * from posts WHERE id=?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();


        $result = $stm->get_result();
        $post = $result->fetch_assoc();

        if ($post) {

        


?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="display-1">Uredi članek</h1>
            <form method="post">

                <!-- Title input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="title" name="title" class="form-control" value="<?php echo $post['title']?>" />
                    <label class="form-label" for="title">Naslov</label>
                </div>


                <!-- Content input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <textarea name="content" id="content"><?php echo $post['content']?></textarea>
                </div>

                <!-- Date select -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="date" id="date" name="date" class="form-control" value = "<?php echo $post['date']?>"/>
                    <label class="form-label" for="date">Datum</label>
                </div>

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Uredi Članek </button>
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


?>

<script src="js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#content'
    });
</script>

<?php
include('includes\footer.php');
?>