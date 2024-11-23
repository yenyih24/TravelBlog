<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    if ($result) {
        echo "<script>alert('Post deleted successfully!'); window.location.href='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error deleting post: " . mysqli_error($db) . "');</script>";
    }
}

// 查询文章信息，用于显示确认弹窗
$sql = "SELECT * FROM post WHERE post_id = '$post_id'";
$result_set = mysqli_query($db, $sql);

if (!$result_set || mysqli_num_rows($result_set) === 0) {
    echo "<script>alert('Post not found!'); window.location.href='index.php';</script>";
    exit;
}

$post = mysqli_fetch_assoc($result_set); // 获取文章数据
?>

<!-- 删除确认弹窗'-->
<script>
        const confirmed = confirm("Are you sure you want to delete the post ?");
        if (confirmed) {
            // 如果用户确认，自动提交表单
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            document.body.appendChild(form);
            form.submit();
        } else {
            // 用户取消，返回主页
            window.location.href = 'index.php';
        }
</script>
</body>
</html>
