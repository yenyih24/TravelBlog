<?php
// Start a session if it hasn't been started already

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!doctype html>

<html lang="en">

<head>
  <title>Blog header</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../css/style.css" />
</head>

<body>
  <header>
    <h1>Travel Blog</h1>

    <nav>
      <ul>
        <li><a href="index.php">Home</a></li> <!-- Link to Home page -->

        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { ?>
          <!-- If the user is logged in, display the welcome message and Log Out link -->
          <li>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
          <li><a href="logout.php">Log Out</a></li> <!-- Link to Logout page -->
        <?php } else { ?>
          <!-- If the user is not logged in, display the Log In link -->
          <li><a href="loginForm.php">Log In</a></li> <!-- Link to Login page -->
        <?php } ?>
      </ul>
    </nav>

  </header>
</body>

</html>
