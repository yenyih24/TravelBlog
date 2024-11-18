<?php
session_start();
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
          <!-- 如果已登入，顯示登出按鈕 -->
          <li>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
          <li><a href="logout.php">Log Out</a></li> <!-- Link to Logout page -->
        <?php } else { ?>
          <!-- 如果未登入，顯示登入按鈕 -->
          <li><a href="loginForm.php">Log In</a></li> <!-- Link to Login page -->
        <?php } ?>
      </ul>
    </nav>

  </header>
</body>

</html>
