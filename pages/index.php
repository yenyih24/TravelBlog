<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Blog - Main page</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
    <?php include 'headerTB.php'; ?>

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

                $sql = "SELECT p.post_id, p.title, p.state, p.country, p.content, p.created_at, a.username ";
                $sql .= "FROM post p ";
                $sql .= "JOIN account a ON p.user_id = a.id "; // Join with the account table to fetch username

                if (!empty($filterStates)) {
                    // 如果有篩選條件，添加 WHERE 子句
                    $placeholders = implode(',', array_fill(0, count($filterStates), '?'));
                    $sql .= "WHERE p.state IN ($placeholders) ";
                }

                $sql .= "ORDER BY p.created_at DESC"; // Order by the most recent posts

                $stmt = $db->prepare($sql);

                if (!empty($filterStates)) {
                    // 動態綁定參數
                    $stmt->bind_param(str_repeat('s', count($filterStates)), ...$filterStates);
                }

                $stmt->execute();
                $result_set = $stmt->get_result(); // Execute the query
                if (!$result_set) {
                    die("Database query failed: " . $db->error);
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

                      <div class="main_link">
                          <ul>
                              <li><a class="action" href="<?php echo "blog.php?id=" . $post['post_id']; ?>">View</a></li>
                              <li><a class="action" href="<?php echo "edit.php?id=" . $post['post_id']; ?>">Edit</a></li>
                              <li><a class="action" href="<?php echo "delete.php?id=" . $post['post_id']; ?>">Delete</a></li>
                          </ul>
                      </div>
                  <?php } ?>
              </div>

            </div>

            <?php $stmt->close(); ?>
        </main>
    </div>

    <?php include 'footerTB.php'; ?>
</body>

</html>
