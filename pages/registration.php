<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 接收表單數據
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // 驗證表單數據是否完整
    if (empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
        die("All fields are required.");
    }

    // 驗證密碼是否匹配
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // 將密碼哈希加密
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 連接資料庫
    $conn = new mysqli('localhost', 'root', '', 'assignment2');
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // 檢查 Email 是否已經存在
    $stmt = $conn->prepare("SELECT * FROM account WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Email already registered.");
    }

    // 插入數據到資料表
    $stmt = $conn->prepare("INSERT INTO account (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error);
    }
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: success.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
