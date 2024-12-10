<?php
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
secure();
include('includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Site Preview</title>
  <!-- MDBootstrap CSS -->
  <link 
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.css" 
    rel="stylesheet">
  <link 
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" 
    rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      color: #4a4a4a;
      background-color: #F8F4F9; 
    }

    header {
      background-color: #E8DAEF; 
      text-align: center;
      padding: 2rem 0;
    }

    header h1 {
      font-size: 2.8rem;
      font-family: 'Playfair Display', serif;
      font-weight: bold;
      color: #4a4a4a;
    }

    .section {
      background-color: white;
      padding: 2rem;
    }

    .section:nth-child(even) {
      background-color: #F4F4F4; 
    }

    .section h2 {
      font-size: 1.5rem;
      color: #4a4a4a;
    }

    .section p {
      color: #6C757D; 
    }

    footer {
      background-color: #AED6F1; 
      color: white;
      text-align: center;
      padding: 1rem 0;
    }


    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <header>
    <h1><b>Kako je nastala Besedna preša: Od ideje do resničnosti</b></h1>
  </header>

  <main class="container-fluid p-0">
    <?php

    //if ($stm = $connect->prepare('SELECT * FROM posts ORDER BY date DESC')) {
      if ($stm = $connect->prepare('
      SELECT posts.*, users.username 
      FROM posts 
      LEFT JOIN users ON posts.author = users.id 
      ORDER BY posts.date ASC
      ')) {   
        $stm->execute();
        $result = $stm->get_result();


        if ($result->num_rows > 0) {
            while ($record = $result->fetch_assoc()) { ?>
                <div class="section">
                  <!--<h2><?php echo htmlspecialchars($record['title']); ?></h2>-->
                  <p><?php echo $record['content']; ?></p>
                  <p><small>Published on: <?php echo htmlspecialchars($record['date']); ?>, by <?php echo htmlspecialchars($record['username']); ?></small></p>
                </div>
            <?php }
        } else {
            echo '<div class="section text-center"><h2>No articles found</h2></div>';
        }
        $stm->close();
    } else {
        echo '<div class="section text-center"><h2>Could not prepare statement!</h2></div>';
    }
    ?>
  </main>


  <script 
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.js">
  </script>
</body>
</html>

<?php
include('includes/footer.php');
?>