<?php
session_start(); // Start the session to manage user login information

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize email and password from the POST request
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['pass'] ?? '');

    // Validate that both email and password are provided
    if (empty($email) || empty($password)) {
        die("<script>alert('Both email and password are required.'); history.back();</script>");
    }

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'assignment2');
    if ($conn->connect_error) {
        die("<script>alert('Database connection failed.'); history.back();</script>");
    }

    // Query the database for a user with the provided email
    $stmt = $conn->prepare("SELECT * FROM account WHERE email = ?");
    $stmt->bind_param("s", $email); // Bind the email parameter to the SQL query
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result of the query

    // Check if the email exists in the database
    if ($result->num_rows === 0) {
        die("<script>alert('No account found with this email.'); history.back();</script>");
    }

    $user = $result->fetch_assoc(); // Fetch the user details as an associative array

    // Verify the password (assuming plain text comparison)
    if ($password === $user['password']) {
        // Store user information in the session
        $_SESSION['user_id'] = $user['id']; // Save the user ID in the session
        $_SESSION['username'] = $user['username']; // Save the username in the session
        $_SESSION['logged_in'] = true; // Set the logged-in status to true

        // Redirect to the main page after successful login
        echo "<script>
                alert('Login successful! Welcome, {$user['username']}');
                window.location.href = 'index.php';
              </script>";
        exit; // Stop further script execution
    } else {
        // If the password is incorrect, show an error message and return to the previous page
        die("<script>alert('Incorrect password.'); history.back();</script>");
    }

    $stmt->close(); // Close the prepared statement
    $conn->close(); // Close the database connection
} else {
    // Handle invalid request method (if not POST)
    echo "<script>alert('Invalid request method.'); history.back();</script>";
}
?>
