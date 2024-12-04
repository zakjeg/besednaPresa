<?php
require 'includes/config.php';
require 'includes/database.php';
secure();

// Enable error reporting for debugging (optional, remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Directory to store uploaded images
$uploadDir = 'uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);  // Ensure the directory exists
}

// Ensure proper content type for JSON response
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['file']['tmp_name']);
        if (!in_array($fileType, $allowedTypes)) {
            echo json_encode(['error' => 'Invalid file type.']);
            exit;
        }

        // Generate a unique filename
        $fileName = uniqid() . '_' . basename($_FILES['file']['name']);
        $filePath = $uploadDir . $fileName;

        // Move the file to the upload directory
        if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
            // Save the image info to the database if needed
            // $stmt = $connect->prepare('INSERT INTO images (user_id, file_name, file_path) VALUES (?, ?, ?)');
            // $stmt->bind_param('iss', $_SESSION['id'], $fileName, $filePath);
            // $stmt->execute();

            // Return the file URL in JSON format
            echo json_encode(['location' => $filePath]);
        } else {
            echo json_encode(['error' => 'Failed to move uploaded file.']);
        }
    } else {
        echo json_encode(['error' => 'No file uploaded or upload error.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
