<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 接收表單數據
    $title = $_POST['title'];
    $state = $_POST['state'];
    $country = $_POST['name'];
    $content = $_POST['post_content'];
    $imagePath = null;

    // 處理圖片上傳
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/images/';
        $fileName = basename($_FILES['picture']['name']);
        $uploadFile = $uploadDir . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // 創建目錄
        }

        if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile; // 保存圖片路徑
        }
    }

    // 將數據保存到資料庫
    $conn = new mysqli('localhost', 'root', '', 'blog');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO post (user_id, title, state, country, content, image_path) VALUES (?, ?, ?, ?, ?, ?)");
    $userId = 1; // 假設當前用戶 ID
    $stmt->bind_param("isssss", $userId, $title, $state, $country, $content, $imagePath);

    if ($stmt->execute()) {
        echo "Post created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
