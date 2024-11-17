<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name=" description " content=" Assignment2 " />
    <!-- Add authorship metadata and link CSS and JS files -->

    <title>Assignment2 - Travel blog- Login page</title>
    <!-- <script src="script.js" defer></script> -->
    <script src="../scripts/script.js" defer></script>
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
<?php include 'headerTB.php'; ?>

    <div class="form-container">
        <h1>User Login In</h1>
        <hr>
        <form name="login" 
        >
        <div class="textfield">
                <label for="login">User Name: </label>
                <input type="text" name="login" id="login" placeholder="User name">
            </div>

            <div class="textfield">
                <label for="pass">Password: </label>
                <input type="password" name="pass" id="pass" placeholder="Password">
            </div>

            <button type="submit">Sign-Up</button>
            <button class="reset" type="reset">Reset</button>

            <p>If you don't have account, <a href="sign.php">Sign up</a></P>

        </form>
    </div>

    <?php include 'footerTB.php'; ?>
</body>

