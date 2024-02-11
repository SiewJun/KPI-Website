<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    <?php echo $pageTitle; ?>
  </title>
  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- Google Fonts - Open Sans -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap">
</head>

<body>
  <!-- NavBar -->
  <?php
  echo '<nav class="navbar bg-dark border-bottom border-body navbar-expand-lg sticky-top" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand d-lg-none" href="index.php">
        <img src="img/mykpilogo.png" alt="Logo" width="40" height="34"
          class="d-inline-block align-text-top">
        MyKPI
      </a>
      <button class="navbar-toggler collapsed btn-primary" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarsExample10" aria-controls="navbarsExample10" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse justify-content-md-center collapse" id="navbarsExample10" style="">
        <ul class="navbar-nav">
          <a class="navbar-brand d-none d-lg-block" href="index.php">
            <img src="img/mykpilogo.png" alt="Logo" width="34" height="34" class="d-inline-block align-text-top">
            MyKPI</a>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="mykpi.php">KPI Indicator</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="activities.php">Activities</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cnfp.php">Challenges and Future Plans</a>
          </li>
          <li class="nav-item nav-pill">
            <a class="" href="logout.php"><button type="button" class="btn btn-primary">Logout</button></a>
          </li>
        </ul>
      </div>
    </div>
  </nav>';
  ?>

  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="breadcrumb-details body-style">
    <ol class="breadcrumb">
      <li class="breadcrumb-item fw-semibold"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item active fw-semibold" aria-current="page">
        <?php echo $pageTitle; ?>
      </li>
    </ol>
  </nav>

  <!-- Body content for individual pages -->
  <div class="container-fluid body-style">
    <?php echo $content; ?>
  </div>

  <!-- Footer -->
  <footer class="container-fluid" id="copyright">
    <a href="#"><button type="button" class="btn btn-primary float-end">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up"
          viewBox="0 0 16 16">
          <path fill-rule="evenodd"
            d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5">
          </path>
        </svg>
      </button>
    </a>
    <p>© 2017–2023 &nbsp; <img src="img/mykpilogo.png" alt="Logo" width="30" height="30">MyKPI, Inc.
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>

</html>