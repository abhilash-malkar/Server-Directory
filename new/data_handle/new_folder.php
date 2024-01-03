<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$directory = '../../..';

if($_REQUEST){
    if(isset($_GET['path'])){
        $path = $directory.$_GET['path'];
        $response = [];

        // Check if the folder doesn't exist before trying to create it
        if (!file_exists($path)) {
            // Create the folder with the specified path
            if (mkdir($path, 0777, true)) {
                $response['success'] = true;
                $response['message'] = "Folder created successfully";
            } else {
                $response['success'] = false;
                $response['message'] = "Failed to create folder or Permission denied";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Folder already exists";
        }

        // Return the JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

?>