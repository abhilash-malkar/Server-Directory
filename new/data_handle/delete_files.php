<?php
$directory = '../../..';

header('Content-Type: application/json');
$response = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the selectedItems array from the POST data
    $selectedItems = $_POST['selectedItems'];

    // Process the selectedItems array as needed
    foreach ($selectedItems as $item) {
        // Your processing logic here
        // For example, you can echo each item:
        $filePath= $directory.$item;
        
        // Check if the file exists before attempting to delete it
        if(file_exists($filePath)){
            // Attempt to delete the file


            if (is_dir($filePath)) {
                // Attempt to delete the directory
                if (rmdir($filePath)) {
                    $response[]=['success' => true, 'message' => 'Directory deleted successfully.'];
                } else {
                    $response[]=['success' => false, 'message' => 'Unable to delete the directory.'];
                }
            } else {
                // It's a file, attempt to delete it
                if (unlink($filePath)) {
                    $response[]=['success' => true, 'message' => 'File deleted successfully.'];
                } else {
                    $response[]=['success' => false, 'message' => 'Unable to delete the file.'];
                }
            }

        } else {
            $response[]=['success' => false, 'message' => 'File not found.'];
        }
    }
} else {
    // Handle the case when the request method is not POST
    $response[]=['success' => false, 'message' => 'Invalid request method.'];
}

echo json_encode($response);
?>
