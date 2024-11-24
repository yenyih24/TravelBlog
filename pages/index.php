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
    session_start();
    include 'headerTB.php'; 
    ?>

    <div class="big-container">
        <aside>
            <!-- Link to the "Create New Post" page -->
            <ul>
                <li><a href="createForm.php">New Post</a></li>
            </ul>

             <!-- 搜尋功能 -->
             <form action="index.php" method="GET">
                <fieldset>
                    <legend>Search Author</legend>
                    <input type="text" name="author" placeholder="Enter author name...">
                    <button type="submit">Search</button>
                </fieldset>
            </form>

            <!-- 篩選功能 -->
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
                require_once('../server/database.php');

                // Establish a database connection
                $db = db_connect();

                // 檢查是否有選中的篩選條件
                $filterStates = isset($_GET['state']) && is_array($_GET['state']) ? $_GET['state'] : []; // 從 GET 獲取篩選條件
                $searchAuthor = isset($_GET['author']) ? mysqli_real_escape_string($db, $_GET['author']) : '';


                $sql = "SELECT p.post_id, p.title, p.state, p.country, p.content, p.image_path, p.created_at, p.user_id, a.username ";
                $sql .= "FROM post p ";
                $sql .= "JOIN account a ON p.user_id = a.id ";

                // 加入篩選條件
                if (!empty($filterStates)) {
                    // 將篩選條件中的每個 state 使用 mysqli_real_escape_string 處理
                    $statesIn = implode("','", array_map(function($state) use ($db) {
                        return mysqli_real_escape_string($db, $state);
                    }, $filterStates));
                    $sql .= "WHERE p.state IN ('$statesIn') ";
                }

                 // 處理作者搜尋條件
                if (!empty($searchAuthor)) {
                    $authorCondition = "a.username LIKE '%" . mysqli_real_escape_string($db, $searchAuthor) . "%'";
                    // 如果已經有篩選條件，則加上 AND，否則加上 WHERE
                    $sql .= !empty($filterStates) ? "AND $authorCondition " : "WHERE $authorCondition ";
                }

                // Order results by creation time (most recent first)
                $sql .= "ORDER BY p.created_at DESC";

                $result_set = mysqli_query($db, $sql);

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

                            <!-- 顯示圖片 -->
                            <?php if (!empty($post['image_path'])): ?>
                                <div class="image-container">
                                    <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="Post Image" width="300">
                                </div>
                            <?php endif; ?>

                            <!-- 限制內容只顯示三行 -->
                            <div class="content-preview">
                                <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                            </div>

                            <!-- 檢查是否是作者 -->
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
