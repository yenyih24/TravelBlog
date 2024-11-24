<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Blog - Main page</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <?php 
    session_start(); // Start the session to manage user login and session data
    include 'headerTB.php'; // Include the header for consistent site navigation
    ?>

    <div class="big-container">
        <aside>
            <!-- Link to the "Create New Post" page -->
            <ul>
                <li><a href="createForm.php">New Post</a></li>
            </ul>

            <!-- Search form to find posts by author -->
            <form action="index.php" method="GET">
                <fieldset>
                    <legend>Search Author</legend>
                    <input type="text" name="author" placeholder="Enter author name...">
                    <button type="submit">Search</button>
                </fieldset>
            </form>

            
            <form method="GET" action="index.php">
                <fieldset>
                    <legend>Filter by State</legend>
                    <!-- Checkboxes for filtering posts based on the state -->
                    <label><input type="checkbox" name="state[]" value="Africa"> Africa</label><br>
                    <label><input type="checkbox" name="state[]" value="Asia"> Asia</label><br>
                    <label><input type="checkbox" name="state[]" value="Europe"> Europe</label><br>
                    <label><input type="checkbox" name="state[]" value="North America"> North America</label><br>
                    <label><input type="checkbox" name="state[]" value="South America"> South America</label><br>
                    <label><input type="checkbox" name="state[]" value="Oceania"> Oceania</label><br>
                </fieldset>
                <button type="submit">Apply Filter</button>
            </form>
        </aside>

        <main class="indexPage">
            <div class="post-container">
            <?php
                require_once('../server/database.php'); // Include database connection file

                // Connect to the database
                $db = db_connect();

                // Fetch filter and search criteria from the GET request
                $filterStates = isset($_GET['state']) && is_array($_GET['state']) ? $_GET['state'] : []; // Filter states
                $searchAuthor = isset($_GET['author']) ? mysqli_real_escape_string($db, $_GET['author']) : ''; // Search author

                // Base SQL query to fetch posts and associated author information
                $sql = "SELECT p.post_id, p.title, p.state, p.country, p.content, p.image_path, p.created_at, p.user_id, a.username ";
                $sql .= "FROM post p ";
                $sql .= "JOIN account a ON p.user_id = a.id ";

                // Add filters for selected states
                if (!empty($filterStates)) {
                // Use mysqli_real_escape_string to process each state in the filter conditions                    
                $statesIn = implode("','", array_map(function($state) use ($db) {
                        return mysqli_real_escape_string($db, $state);
                    }, $filterStates));
                    $sql .= "WHERE p.state IN ('$statesIn') ";
                }

                 // Add search condition for author
                if (!empty($searchAuthor)) {
                    $authorCondition = "a.username LIKE '%" . mysqli_real_escape_string($db, $searchAuthor) . "%'";
                    $sql .= !empty($filterStates) ? "AND $authorCondition " : "WHERE $authorCondition ";
                }

                // Order results by creation time (most recent first)
                $sql .= "ORDER BY p.created_at DESC";

                $result_set = mysqli_query($db, $sql);// Execute the query

                 // Check if the query execution was successful
                if (!$result_set) {
                    die("Database query failed: " . mysqli_error($db));
                }
                ?>

                <div class="blog">
                    <?php while ($post = mysqli_fetch_assoc($result_set)) { ?>
                        <div class="post">
                            <h1><?php echo htmlspecialchars($post['title']); ?></h1>
                            <h3><?php echo htmlspecialchars($post['state']); ?></h3>
                            <p><?php echo htmlspecialchars($post['country']); ?></p>
                            <p>Author: <?php echo htmlspecialchars($post['username']); ?></p>

                            <!-- Display the post image if it exists -->
                            <?php if (!empty($post['image_path'])): ?>
                                <div class="image-container">
                                    <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post Image" width="300">
                                </div>
                            <?php endif; ?>

                            <!-- Display a preview of the post content -->
                            <div class="content-preview">
                                <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                            </div>

                            <!-- Action links: View, Edit, Delete -->
                            <div class="main_link">
                                <ul>
                                    <!-- View link available to all users -->
                                    <li><a class="action" href="<?php echo "blog.php?id=" . $post['post_id']; ?>">View</a></li>
                                    <!-- Check if the logged-in user is the author of the post-->
                                    <?php 
                                    // Display Edit and Delete options only for the post author
                                    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']) { 
                                    ?>
                                        <li><a class="action" href="<?php echo "edit.php?id=" . $post['post_id']; ?>">Edit</a></li>
                                        <li><a class="action" href="<?php echo "delete.php?post_id=" . $post['post_id']; ?>">Delete</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <br><br><br>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Close the database connection -->
            <?php mysqli_close($db); ?>
        </main>
    </div>

    <?php 
    // Include the footer file
    include 'footerTB.php'; 
    ?>
</body>

</html>
