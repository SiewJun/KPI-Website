<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    Register
  </title>
  <!-- CSS -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="login-background">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

  <!-- Registration Form -->
  <div class="container-fluid">
    <form class="text-center mx-auto details-form shadow" method="post" action="registration.php">
      <img class="mb-4" src="img/mykpilogo.png" alt="Logo" style="max-width: 55%; height: auto;">
      <h1 class="h3 mb-3 fw-normal">Register</h1>
      <div class="form-floating">
        <input type="text" name="matricNo" class="form-control" placeholder="matricNo" required>
        <label for="floatingInput">Matric No</label>
      </div>
      <div class="form-floating">
        <input type="email" name="userEmail" class="form-control" placeholder="Email" required>
        <label for="floatingInput">Email</label>
      </div>
      <div class="form-floating">
        <input type="password" name="userPassword" class="form-control" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
      </div>
      <div class="form-floating">
        <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password" required>
        <label for="floatingPassword">Confirm Password</label>
      </div>
      <button class="btn btn-primary w-100 py-2 my-3" name="login" type="submit">Register</button>
      <p>Already have an account? <a href="login.php">Sign in</a></p>
    </form>
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
</body>

</html>

