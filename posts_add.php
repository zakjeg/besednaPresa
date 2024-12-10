<?php
//posts_add.php

include('includes\config.php');
include('includes\database.php');
include('includes\functions.php');
secure();
include('includes\header.php');



if(isset($_POST['title'])){



    if($stm = $connect-> prepare('INSERT INTO posts (title, content, author, date) VALUES (?,?,?,?)')){
        $stm->bind_param('ssss', $_POST['title'],$_POST['content'],$_SESSION['id'], $_POST['date']);
        $stm->execute();

        set_message("Uspešno dodan nov članek - " . $_SESSION['title'], false);
        header('Location: posts.php');
        $stm->close(); 
        die();
        }else{
            echo 'Could not prepare statement!';
        }
        
    
}

?>

?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="display-1">Dodaj članek</h1>
            <form method="post">

                <!-- Title input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="text" id="title" name="title" class="form-control" />
                    <label class="form-label" for="title">Naslov</label>
                </div>


                <!-- Content input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <textarea name="content" id="content"></textarea>
                </div>

                <!-- Date select -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input type="date" id="date" name="date" class="form-control" required/>
                    <label class="form-label" for="date">Datum</label>
                </div>

                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block">Dodaj Članek </button>
            </form>

        </div>
    </div>
</div>



<script src="js/tinymce/tinymce.min.js"></script>

<script>
    tinymce.init({
        selector: '#content'
    });
</script>
<?php
include('includes\footer.php');
?>