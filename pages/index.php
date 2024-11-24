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
    // Start a new session or resume the existing session
    session_start();

    // Include the header file for consistent page navigation
    include 'headerTB.php'; 
    ?>

    <div class="big-container">
        <aside>
            <!-- Link to the "Create New Post" page -->
            <ul>
                <li><a href="createForm.php">New Post</a></li>
            </ul>

            <!-- Search form to find posts by author name -->
            <form action="index.php" method="GET">
                <fieldset>
                    <legend>Search Author</legend>
                    <input type="text" name="author" placeholder="Enter author name...">
                    <button type="submit">Search</button>
                </fieldset>
            </form>

            <!-- Filter form to display posts by selected states -->
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
                // Include the database connection script
                require_once('../server/database.php');

                // Establish a database connection
                $db = db_connect();

                // Retrieve selected filter states from the GET request
                $filterStates = isset($_GET['state']) && is_array($_GET['state']) ? $_GET['state'] : [];

                // Retrieve the author search query from the GET request
                $searchAuthor = isset($_GET['author']) ? mysqli_real_escape_string($db, $_GET['author']) : '';

                // Construct the SQL query to fetch posts
                $sql = "SELECT p.post_id, p.title, p.state, p.country, p.content, p.image_path, p.created_at, p.user_id, a.username ";
                $sql .= "FROM post p ";
                $sql .= "JOIN account a ON p.user_id = a.id ";

                // Add conditions for filtering by state
                if (!empty($filterStates)) {
                    $statesIn = implode("','", array_map(function($state) use ($db) {
                        return mysqli_real_escape_string($db, $state);
                    }, $filterStates));
                    $sql .= "WHERE p.state IN ('$statesIn') ";
                }

                // Add conditions for searching by author name
                if (!empty($searchAuthor)) {
                    $authorCondition = "a.username LIKE '%" . mysqli_real_escape_string($db, $searchAuthor) . "%'";
                    $sql .= !empty($filterStates) ? "AND $authorCondition " : "WHERE $authorCondition ";
                }

                // Order results by creation time (most recent first)
                $sql .= "ORDER BY p.created_at DESC";

                // Execute the query
                $result_set = mysqli_query($db, $sql);

                // Check for query errors
                if (!$result_set) {
                    die("Database query failed: " . mysqli_error($db));
                }
                ?>

                <div class="blog">
                    <!-- Loop through the result set and display each post -->
                    <?php while ($post = mysqli_fetch_assoc($result_set)) { ?>
                        <div class="post">
                            <!-- Display the post title -->
                            <h1><?php echo htmlspecialchars($post['title']); ?></h1>

                            <!-- Display the state and country of the post -->
                            <h3><?php echo htmlspecialchars($post['state']); ?></h3>
                            <p><?php echo htmlspecialchars($post['country']); ?></p>

                            <!-- Display the author of the post -->
                            <p>Author: <?php echo htmlspecialchars($post['username']); ?></p>

                            <!-- Display the post image if available -->
                            <?php if (!empty($post['image_path'])): ?>
                                <div class="image-container">
                                    <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post Image" width="300">
                                </div>
                            <?php endif; ?>

                            <!-- Display a preview of the post content (limited to three lines) -->
                            <div class="content-preview">
                                <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                            </div>

                            <!-- Provide action links for each post -->
                            <div class="main_link">
                                <ul>
                                    <!-- View link available to all users -->
                                    <li><a class="action" href="<?php echo "blog.php?id=" . $post['post_id']; ?>">View</a></li>
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
