<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // 如果未登入，跳轉到登入頁面
    header("Location: loginForm.php");
    exit;
}

$userId = $_SESSION['user_id']; // 從 Session 獲取用戶 ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 接收表單數據
    $title = $_POST['title'] ?? '';
    $state = $_POST['state'] ?? '';
    $country = $_POST['country'] ?? '';
    $content = $_POST['post_content'] ?? '';
    $imagePath = null;

    // 處理圖片上傳
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/images/';
        $fileName = basename($_FILES['picture']['name']);
        $uploadFile = $uploadDir . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // 創建目錄
        }

        if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile)) { //save the file in the specific path
            $imagePath = $uploadFile;
        } else {
            die("Failed to upload picture.");
        }
    }

    // 連接資料庫
    $conn = new mysqli('localhost', 'root', '', 'assignment2');
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // 插入數據
    $stmt = $conn->prepare("INSERT INTO post (user_id, title, state, country, content, image_path) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error);
    }

    $stmt->bind_param("isssss", $userId, $title, $state, $country, $content, $imagePath);

    if ($stmt->execute()) {
        echo "<script>
            alert('Post Created Successfully!');
            window.location.href = 'index.php';
        </script>";
        exit; // 確保腳本執行停止
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
