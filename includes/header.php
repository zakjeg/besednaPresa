<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BesednaPreša</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"
    />
    <link rel="stylesheet" href="css/mdb.min.css" />
    <link rel="stylesheet" href="css/customcss.css" />
    <link rel="icon" type="image/png"  href="besednapresa_logo3.png" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
  <div class="container-fluid">
  <a class="navbar-brand d-flex align-items-center" href="/seminarska_RSO">
    <img src="besednapresa_logo3.png" alt="Logo" style="height: 1.5rem; margin-right: 0.5rem;">
    BesednaPreša
  </a>
    <!-- <a class="navbar-brand" href="/seminarska_RSO">WordSqueeze</a> -->
    <button
      data-mdb-collapse-init
      class="navbar-toggler"
      type="button"
      data-mdb-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <!-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/cms">Domov</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Nadzorna plošča</a>
        </li>
        <!--<li class="nav-item">
          <a class="nav-link" href="logout.php">Odjava</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" href="page_preview.php"><b>Predogled spletne strani</b></a>
        </li>
      </ul>

      <div class="ms-auto d-flex align-items-center">
    <span class="navbar-text">
        <?php if (isset($_SESSION['username'])): ?>
            Uporabnik: <strong><?php echo $_SESSION['username']; ?></strong>
            <a href="logout.php" class="btn btn-sm btn-primary text-white ms-2" data-mdb-ripple-init>Odjava</a>
        <?php endif; ?>
    </span>
</div>

      <!-- <div class="ms-auto">
      <span class="navbar-text">
        <?php if (isset($_SESSION['username'])) echo "Uporabnik : ".$_SESSION['username']; ?>
        <a href="logout.php" class="ms-auto btn btn-outline-secondary">Odjava</a>
      </span>
      </div> -->


    </div>
  </div>
</nav>

<!-- <a class="nav-link" href="logout.php">Odjava</a> -->


