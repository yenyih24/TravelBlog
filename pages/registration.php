<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the request method is POST and process the form data

    // Retrieve and sanitize form data
    $email = trim($_POST['email'] ?? ''); // Get the email input, or set it to an empty string if not provided
    $username = trim($_POST['username'] ?? ''); // Get the username input
    $password = trim($_POST['password'] ?? ''); // Get the password input
    $confirmPassword = trim($_POST['confirm_password'] ?? ''); // Get the password confirmation input

    // Validate that all fields are filled out
    if (empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
        die("All fields are required."); // Exit the script with an error message
    }

    // Validate that the passwords match
    if ($password !== $confirmPassword) {
        die("Passwords do not match."); // Exit the script if passwords are different
    }

    // At this point, passwords match; hash the password for security
    $hashedPassword = $password; // In production, use password_hash() for secure password storage

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'assignment2'); // Create a new database connection
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error); // Exit if the connection fails
    }

    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT * FROM account WHERE email = ?"); // Prepare a query to search for the email
    $stmt->bind_param("s", $email); // Bind the email parameter
    $stmt->execute(); // Execute the query
    $result = $stmt->get_result(); // Fetch the query result

    if ($result->num_rows > 0) {
        die("Email already registered."); // Exit if the email is already in use
    }

    // Insert the new user into the account table
    $stmt = $conn->prepare("INSERT INTO account (username, email, password) VALUES (?, ?, ?)"); // Prepare the insert query
    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error); // Exit if the query preparation fails
    }
    $stmt->bind_param("sss", $username, $email, $hashedPassword); // Bind the input parameters to the query

    if ($stmt->execute()) {
        // If the query is successful, redirect the user to the login page with a success message
        echo "<script>
            alert('Registration successful! You can now log in.');
            window.location.href = 'loginForm.php';
        </script>";
        exit; // Ensure no further code is executed after redirection
    } else {
        echo "Error: " . $stmt->error; // Display an error if the query execution fails
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle invalid request methods (only POST requests are allowed for registration)
    echo "Invalid request method.";
}
?>
