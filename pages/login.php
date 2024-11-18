<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['pass'] ?? '');

    // 驗證數據是否完整
    if (empty($email) || empty($password)) {
        die("<script>alert('Both email and password are required.'); history.back();</script>");
    }

    // 連接資料庫
    $conn = new mysqli('localhost', 'root', '', 'assignment2');
    if ($conn->connect_error) {
        die("<script>alert('Database connection failed.'); history.back();</script>");
    }

    // 查詢用戶
    $stmt = $conn->prepare("SELECT * FROM account WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("<script>alert('No account found with this email.'); history.back();</script>");
    }

    $user = $result->fetch_assoc();

    // 驗證密碼
    if ($password === $user['password']) {
        // 使用 JavaScript 彈出訊息並跳轉
        echo "<script>
                alert('Login successful! Welcome, {$user['username']}');
                window.location.href = 'index.php'; // 跳轉到首頁
              </script>";
        exit;
    } else {
        die("<script>alert('Incorrect password.'); history.back();</script>");
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request method.'); history.back();</script>";
}
?>
