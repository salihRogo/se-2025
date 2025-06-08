<?php
// filepath: /Applications/MAMP/htdocs/webprogramming2025/api/upload/event-image/index.php

header('Content-Type: application/json');

// Set the target directory for event images
$targetDir = __DIR__ . "/../../../../frontend/assets/img/";

// Create directory if it doesn't exist
if (!file_exists($targetDir)) {
    if (!mkdir($targetDir, 0777, true)) {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Failed to create upload directory: " . $targetDir
        ]);
        exit;
    }
}

if (isset($_FILES["shopImage"])) {
    $file = $_FILES["shopImage"];

    // Generate unique filename
    $filename = uniqid() . "_" . basename($file["name"]);
    $targetFile = $targetDir . $filename;

    // Move the file to the target directory
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        // Return the filename to be stored in the database
        echo json_encode([
            "success" => true,
            "filename" => $filename
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Failed to save the file."
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "No file uploaded."
    ]);
}