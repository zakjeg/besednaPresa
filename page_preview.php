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
      color: #4a4a4a; /* Soft gray for text */
      background-color: #F8F4F9; /* Very light pastel pink */
    }

    header {
      background-color: #E8DAEF; /* Light lavender */
      text-align: center;
      padding: 2rem 0;
    }

    header h1 {
      font-size: 2.8rem;
      font-family: 'Playfair Display', serif;
      font-weight: bold;
      color: #4a4a4a; /* Gray for standout text */
    }

    .section {
      background-color: white;
      padding: 2rem;
    }

    .section:nth-child(even) {
      background-color: #F4F4F4; /* Light gray for alternating sections */
    }

    .section h2 {
      font-size: 1.5rem;
      color: #4a4a4a; /* Keep title standout gray */
    }

    .section p {
      color: #6C757D; /* Muted gray for body text */
    }

    footer {
      background-color: #AED6F1; /* Soft pastel blue */
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
    <h1>Ne se fugirat!</h1>
  </header>

  <main class="container-fluid p-0">
    <?php
    // Prepare the SQL statement to retrieve all posts
    //if ($stm = $connect->prepare('SELECT * FROM posts ORDER BY date DESC')) {
      if ($stm = $connect->prepare('
      SELECT posts.*, users.username 
      FROM posts 
      LEFT JOIN users ON posts.author = users.id 
      ORDER BY posts.date DESC
      ')) {   
        $stm->execute();
        $result = $stm->get_result();

        // Check if there are any posts
        if ($result->num_rows > 0) {
            while ($record = $result->fetch_assoc()) { ?>
                <div class="section">
                  <h2><?php echo htmlspecialchars($record['title']); ?></h2>
                  <p><?php echo $record['content']; ?></p> <!-- Display HTML content directly -->
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

  <!-- MDBootstrap JS -->
  <script 
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.js">
  </script>
</body>
</html>

<?php
include('includes/footer.php');
?>
