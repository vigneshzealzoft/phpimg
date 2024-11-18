<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST'); // Allow only POST method
header('Content-Type: application/json'); // Set JSON response

// Directory where images will be saved
$uploadDir = 'upload/';

// Create the directory if it doesn't exist
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
 
// Check if a file was uploaded
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Generate a unique name for the uploaded file
    $fileName = time() . '_' . basename($file['name']);
    $filePath = $uploadDir . $fileName;

    // Move the uploaded file to the server
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        // File successfully uploaded
        $response = [
            'success' => true,
            'message' => 'File uploaded successfully.',
            'file_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/' . $filePath
        ];
        echo json_encode($response);
    } else {
        // Error during upload
        $response = [
            'success' => false,
            'message' => 'Failed to upload the file.'
        ];
        echo json_encode($response);
    }
} else {
    // No file received
    $response = [
        'success' => false,
        'message' => 'No file uploaded.'
    ];
    echo json_encode($response);
}
