

<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();
include('includes/header.php');
?>

<h1>Zivjo!! žau predogled spletne starni še ni zrihtan, je nekaj zgolj simbolicnega tko da vidmo ce dela :)</h1>
<h2>Ampak cilj je seveda da lahko njeno vsebino spreminjamo s pomočjo nadzorne plošče!</h2>
<h3>Stay tuned tu see it work!</h3>
<marquee><h4>Ampak hvala za obisk pa se vidimo kmalu!</h4></marquee>

<?php
// Prepare the SQL statement to retrieve all posts
if ($stm = $connect->prepare('SELECT * FROM posts ORDER BY date DESC')) {
    $stm->execute();
    $result = $stm->get_result();

    // Check if there are any posts
    if ($result->num_rows > 0) {
        ?>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <h1 class="display-1">Članki!</h1>
                    <div class="articles">
                        <?php while ($record = $result->fetch_assoc()) { ?>
                            <div class="article">
                                <h2><?php echo htmlspecialchars($record['title']); ?></h2>
                                <p><strong>Author:</strong> <?php echo htmlspecialchars($record['author']); ?></p>
                                <p><?php echo $record['content']; // Display HTML content directly ?></p>
                                <p><small>Published on: <?php echo htmlspecialchars($record['date']); ?></small></p>
                                <hr>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
    } else {
        echo '<div class="container mt-5"><div class="row justify-content-center"><div class="col-md-9"><h2>No articles found</h2></div></div></div>';
    }

    $stm->close();
} else {
    echo '<div class="container mt-5"><div class="row justify-content-center"><div class="col-md-9"><h2>Could not prepare statement!</h2></div></div></div>';
}

include('includes/footer.php');
?>

