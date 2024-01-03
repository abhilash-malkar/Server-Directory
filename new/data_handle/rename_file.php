<?php
$directory = '../../..';
header('Content-Type: application/json');
// Check if the necessary parameters are set
if (isset($_POST['selectedItems']) && isset($_POST['rename'])) {
    
    // Assuming selectedItems is an array of file/directory names to be renamed
    $selectedItems = $_POST['selectedItems'];
    
    // The new name for the file/directory
    $newName = $_POST['rename'];
    
    // The path where the file/directory is located
    $path = $directory ; // Replace with the actual path
    
    // Initialize status and messages array
    // $statuses = array();

    // Loop through each selected item and perform the renaming
    foreach ($selectedItems as $item) {
        $oldPath = $path . $item;
        $newPath = $path .$newName;
        if (file_exists($newPath)) {
            echo json_encode(['success' => false, 'message' => 'File or folder already exists']);
        }else{
            // Perform the rename operation
            if (rename($oldPath, $newPath)) {
                echo json_encode(['success' => true, 'message' => 'Renamed '. $item]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to rename ' . $item]);

                // You can add more specific error handling if needed
            }
        }

    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
}

?>
