<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Delete Post</title>
</head>
<body>
<?php
// 引入数据库连接
require_once('../server/database.php'); 
$db = db_connect();

// 验证是否提供了 post_id 参数
if (!isset($_GET['post_id'])) {
    header("Location: index.php");
    exit;
}

$post_id = $_GET['post_id']; // 获取传递的 post_id

// 如果是 POST 请求，执行删除操作
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "DELETE FROM post WHERE post_id = '$post_id'";
    $result = mysqli_query($db, $sql);

    // 删除成功后跳转回主页面
    if ($result) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting post: " . mysqli_error($db);
    }
} else {
    // 查询文章信息，用于显示确认删除界面
    $sql = "SELECT * FROM post WHERE post_id = '$post_id'";
    $result_set = mysqli_query($db, $sql);

    if (!$result_set || mysqli_num_rows($result_set) === 0) {
        echo "<p>Post not found with ID: $post_id</p>";
        echo '<a href="index.php">Back to List</a>';
        exit;
    }

    $post = mysqli_fetch_assoc($result_set); // 获取文章数据
}
?>

<div id="content">
    <a class="back-link" href="index.php">&laquo; Back to List</a>

    <div class="page delete">
        <h1>Delete Post</h1>
        <p>Are you sure you want to delete this post?</p>
        <p class="item"><?php echo htmlspecialchars($post['title']); ?></p>

        <form action="<?php echo 'delete.php?post_id=' . $post_id; ?>" method="post">
            <div id="operations">
                <input type="submit" name="commit" value="Delete Post">
            </div>
        </form>
    </div>
</div>
<?php include 'footerTB.php'; ?>
</body>
</html>
