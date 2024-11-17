<?php
// 檢查是否有表單提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. 接收表單數據
    $title = $_POST['title'];                 // 標題
    $state = $_POST['state'];                 // 地區
    $country = $_POST['name'];                // 國家
    $content = $_POST['post_content'];        // 文章內容
    $imagePath = null;                        // 圖片路徑初始化
    $userId = 1;                              // 假設當前用戶 ID 為 1（未處理登入邏輯）

    // 2. 處理圖片上傳
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/images/';       // 圖片上傳目錄
        $fileName = basename($_FILES['picture']['name']);
        $uploadFile = $uploadDir . $fileName;

        // 確保目錄存在
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);    // 創建目錄
        }

        // 移動上傳文件到目標目錄
        if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile;        // 保存圖片路徑
        } else {
            die("Failed to upload picture.");
        }
    }

    // 3. 連接資料庫
    $conn = new mysqli('localhost', 'root', '', 'blog'); // 修改為你的資料庫名稱
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 4. 插入數據到資料表
    $stmt = $conn->prepare("INSERT INTO post (title, state, country, content, image_path) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $userId, $title, $state, $country, $content, $imagePath);

    if ($stmt->execute()) {
        echo "Post created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // 5. 關閉連接
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
