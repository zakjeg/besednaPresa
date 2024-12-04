<?php
//dashboard

include('includes\config.php');
include('includes\database.php');
include('includes\functions.php');
secure();
include('includes\header.php');







?>


<div class="container mt-5">
    <div class="row justify-content-center">    
        <div class="col-md-6">
                <h1 class="display-1">Nadzorna plošča</h1>
                <br>
                    <!-- Button for Users management -->
                    <button type="button" class="btn btn-warning me-2" data-mdb-ripple-init onclick="window.location.href='users.php'">Urejanje uporabnikov</button>

                    <!-- Button for Posts management -->
                    <button type="button" class="btn btn-info me-2" data-mdb-ripple-init onclick="window.location.href='posts.php'">Urejanje strani</button>

        </div>
    </div>
</div>




<?php
//var_dump($_SESSION);
include('includes\footer.php');
?>