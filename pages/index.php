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
            <ul>
                <li><a href="createForm.php">New Post</a></li>
            </ul>

            <!-- 篩選功能 -->
            <form method="GET" action="index.php">
                <fieldset>
                    <legend>Filter by State</legend>
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

        <main>
            <div class="post-container">
                <?php
                require_once('../server/database.php');

                $db = db_connect(); // Connect to the database

                // 檢查是否有選中的篩選條件
                $filterStates = $_GET['state'] ?? []; // 從 GET 獲取篩選條件（多選框的值）

                $sql = "SELECT p.post_id, p.title, p.state, p.country, p.content, p.created_at, p.user_id, a.username ";
                $sql .= "FROM post p ";
                $sql .= "JOIN account a ON p.user_id = a.id "; // Join with the account table to fetch username

                if (!empty($filterStates)) {
                    $statesIn = implode("','", array_map('mysqli_real_escape_string', $filterStates));
                    $sql .= "WHERE p.state IN ('$statesIn') ";
                }

                $sql .= "ORDER BY p.created_at DESC";

                $result_set = mysqli_query($db, $sql);

                if (!$result_set) {
                    die("Database query failed: " . mysqli_error($db));
                }
                ?>

                <div class="blog">
                    <?php while ($post = mysqli_fetch_assoc($result_set)) { ?>
                        <h1><?php echo htmlspecialchars($post['title']); ?></h1>
                        <h3><?php echo htmlspecialchars($post['state']); ?></h3>
                        <p><?php echo htmlspecialchars($post['country']); ?></p>

                        <!-- 限制內容只顯示三行 -->
                        <div class="content-preview">
                            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                        </div>

                        <!-- 檢查是否是作者 -->
                        <div class="main_link">
                            <ul>
                                <li><a class="action" href="<?php echo "blog.php?id=" . $post['post_id']; ?>">View</a></li>
                                <?php 
                                if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $post['user_id']) { 
                                ?>
                                    <li><a class="action" href="<?php echo "edit.php?id=" . $post['post_id']; ?>">Edit</a></li>
                                    <li><a class="action" href="<?php echo "delete.php?post_id=" . $post['post_id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php mysqli_close($db); ?>
        </main>
    </div>

    <?php include 'footerTB.php'; ?>
</body>

</html>
