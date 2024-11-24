<?php
session_start();

// Check if the user is logged in; if not, redirect them to the login page.
if (!isset($_SESSION['user_id'])) {
    header("Location: loginForm.php"); // Redirect to login page.
    exit; // Stop further script execution.
}

// Retrieve the logged-in user's ID from the session.
$userId = $_SESSION['user_id'];

// Check if the request method is POST (indicating form submission).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data with a fallback to empty strings if the fields are not set.
    $title = $_POST['title'] ?? '';
    $state = $_POST['state'] ?? '';
    $country = $_POST['country'] ?? '';
    $content = $_POST['post_content'] ?? '';
    $imagePath = null; // Initialize image path as null.

    // Handle image upload if a file is provided.
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/images/'; // Define the directory to store uploaded images.
        $fileName = basename($_FILES['picture']['name']); // Extract the base name of the uploaded file.
        $uploadFile = $uploadDir . $fileName; // Full path to the uploaded file.

        // Create the directory if it does not exist.
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory with write permissions.
        }

        // Attempt to move the uploaded file to the specified location.
        if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile; // Store the file path if upload is successful.
        } else {
            die("Failed to upload picture."); // Stop execution if file upload fails.
        }
    }

    // Connect to the MySQL database.
    $conn = new mysqli('localhost', 'root', '', 'assignment2');
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error); // Exit if connection fails.
    }

    // Prepare an SQL statement to insert post data into the database.
    $stmt = $conn->prepare("INSERT INTO post (user_id, title, state, country, content, image_path) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error); // Exit if statement preparation fails.
    }

    // Bind parameters to the prepared statement. 
    // 'i' indicates an integer, while 's' indicates strings.
    $stmt->bind_param("isssss", $userId, $title, $state, $country, $content, $imagePath);

    // Execute the SQL statement.
    if ($stmt->execute()) {
        // If the execution is successful, notify the user and redirect to the index page.
        echo "<script>
            alert('Post Created Successfully!');
            window.location.href = 'index.php';
        </script>";
        exit; // Ensure no further code is executed after the redirect.
    } else {
        // Output an error message if the execution fails.
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement and database connection.
    $stmt->close();
    $conn->close();
} else {
    // Output an error message if the request method is not POST.
    echo "Invalid request method.";
}
?>
