<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Post</title>
</head>
<body>
<?php
// Include the database connection
require_once('../server/database.php'); 
$db = db_connect();

// Verify if the `post_id` parameter is provided
if (!isset($_GET['post_id'])) {
    header("Location: index.php");
    exit;
}

$post_id = $_GET['post_id']; // Retrieve the passed `post_id`

// If it is a POST request, perform the delete operation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "DELETE FROM post WHERE post_id = '$post_id'";
    $result = mysqli_query($db, $sql);

    if ($result) {
        echo "<script>alert('Post deleted successfully!'); window.location.href='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error deleting post: " . mysqli_error($db) . "');</script>";
    }
}

// Query post information to display the confirmation dialog
$sql = "SELECT * FROM post WHERE post_id = '$post_id'";
$result_set = mysqli_query($db, $sql);

if (!$result_set || mysqli_num_rows($result_set) === 0) {
    echo "<script>alert('Post not found!'); window.location.href='index.php';</script>";
    exit;
}

$post = mysqli_fetch_assoc($result_set); // Retrieve post data
?>

<!-- Delete confirmation dialog-->
<script>
        const confirmed = confirm("Are you sure you want to delete the post ?");
        if (confirmed) {
            // If the user confirms, automatically submit the form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            document.body.appendChild(form);
            form.submit();
        } else {
            // If the user cancels, return to the homepage
            window.location.href = 'index.php';
        }
</script>
</body>
</html>
