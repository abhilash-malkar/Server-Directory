<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// $directory = '../../..';
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
//     $path=$directory.$_POST['path'];
//     $response = [];

//     $file = $_FILES['file'];

//     // file will be uploaded to the following folder
//     // you should give sufficient file permissions
//     $uploadDir = $path;

//     // unique file name generated
//     $fileName = $file['name'];

//     // moving the uploaded file from temp location to our target location
//     if (move_uploaded_file($file['tmp_name'], $uploadDir ."/". $fileName)) {
//         $response['success'] = true;
//         $response['message'] = "File uploaded successfully.";
//     } else {
//         $response['success'] = false;
//         $response['message'] = "Failed to upload file.";
//     }

//     // Return the JSON response
//     header('Content-Type: application/json');
//     echo json_encode($response);
// }

?>

<?php
// $directory = '../../..';
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files'])) {
//     $path = $directory . $_POST['path'];
//     $response = [];

//     $uploadedFiles = $_FILES['files'];

//     for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
//         $file = [
//             'name' => $uploadedFiles['name'][$i],
//             'type' => $uploadedFiles['type'][$i],
//             'tmp_name' => $uploadedFiles['tmp_name'][$i],
//             'error' => $uploadedFiles['error'][$i],
//             'size' => $uploadedFiles['size'][$i],
//         ];

//         // unique file name generated
//         $fileName = $file['name'];

//         // moving the uploaded file from temp location to our target location
//         if (move_uploaded_file($file['tmp_name'], $path . "/" . $fileName)) {
//             $response['success'] = true;
//             $response['message'] = "Files uploaded successfully.";
//         } else {
//             $response['success'] = false;
//             $response['message'] = "Failed to upload files.";
//         }
//     }

//     // Return the JSON response
//     header('Content-Type: application/json');
//     echo json_encode($response);
// }
?>

<?php
$directory = '../../..';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['files'])) {
    $path = $directory . $_POST['path'];
    $response = [];

    $uploadedFiles = $_FILES['files'];

    for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
        $file = [
            'name' => $uploadedFiles['name'][$i],
            'type' => $uploadedFiles['type'][$i],
            'tmp_name' => $uploadedFiles['tmp_name'][$i],
            'error' => $uploadedFiles['error'][$i],
            'size' => $uploadedFiles['size'][$i],
        ];

        // Unique file name generated
        $fileName = $file['name'];
        $targetFilePath = $path . "/" . $fileName;

        // Check if the file already exists
        if (file_exists($targetFilePath)) {
            $response['success'] = false;
            $response['message'] = "File '{$fileName}' already exists.";
        } else {
            // Move the uploaded file from the temp location to our target location
            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                $response['success'] = true;
                $response['message'] = "File '{$fileName}' uploaded successfully.";
            } else {
                $response['success'] = false;
                $response['message'] = "Failed to upload file '{$fileName}'.";
            }
        }
    }

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
