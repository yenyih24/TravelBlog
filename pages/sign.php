<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name=" description " content=" Assignment2 " />
    <!-- Add authorship metadata and link CSS and JS files -->

    <title>Assignment2 - Travel blog- Registration Form</title>
    <!-- <script src="script.js" defer></script> -->
    <script src="../scripts/script.js" defer></script>
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">

</head>
<body>

<?php include 'headerTB.php'; ?>

    <div class="form-container">
        <h1>Customer Registration Form</h1>
        <hr>
        <form name="registration" action="registration.php"  method="post">
            

            <div class="textfield">
                <label for="email">Email Address: </label>
                <input type="text" name="email" id="email" placeholder="Email">
            </div>

            <div class="textfield">
                <label for="username">User Name: </label>
                <input type="text" name="username" id="username" placeholder="User name">
            </div>

            <div class="textfield">
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
        
            <div class="textfield">
                <label for="confirm_password">Re-type Password: </label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Password" required>
            </div>


            <div class="checkbox">
                <input type="checkbox" name="newsletter" id="newsletter">
                <label for="newsletter">I agree to receive newsletters</label>
            </div>

            <div class="checkbox">
                <input type="checkbox" name="terms" id="terms">
                <label for="terms">I agree to the terms and conditions</label>
            </div>

            <button type="submit">Sign-Up</button>
            <button class="reset" type="reset">Reset</button>

        </form>
    </div>
    <?php include 'footerTB.php'; ?>

</body>

</html>