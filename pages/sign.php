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
</head>
<body>
    <div class="form-container">
        <h1>Customer Registration Form</h1>
        <hr>
        <form name="registration" 
        action="sign.php" 
        onsubmit="return validate();" 
        method="get">
            

            <div class="textfield">
                <label for="email">Email Address: </label>
                <input type="text" name="email" id="email" placeholder="Email">
            </div>

            <div class="textfield">
                <label for="login">User Name: </label>
                <input type="text" name="login" id="login" placeholder="User name">
            </div>

            <div class="textfield">
                <label for="pass">Password: </label>
                <input type="password" name="pass" id="pass" placeholder="Password">
            </div>
        
            <div class="textfield">
                <label for="pass2">Re-type Password: </label>
                <input type="password" id="pass2" placeholder="Password">
            </div>

            <div class="checkbox">
                <input type="checkbox" name="newsletter" id="newsletter">
                <label for="newsletter">I agree to receive Weekly Kitten Pictures newsletters</label>
            </div>

            <div class="checkbox">
                <input type="checkbox" name="terms" id="terms">
                <label for="terms">I agree to the terms and conditions</label>
            </div>

            <button type="submit">Sign-Up</button>
            <button class="reset" type="reset">Reset</button>

        </form>
    </div>

</body>
</html>