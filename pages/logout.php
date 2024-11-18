<?php
session_start();
session_unset();
session_destroy();
echo "You have been logged out."; // 確保執行到這一步
header("Location: index.php");
exit;
?>