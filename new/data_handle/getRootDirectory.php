<?php

$path = $directory = '../../../'; // Replace with the actual path to your files

if($_REQUEST){
    if(isset($_GET['path'])){
        $path = $directory = '../../../'. $_GET['path'];
    }else{
        $path = $directory = '../../../';
    }
}


$files = scandir($directory);

$icons = array(
    'csv' => 'csv.png',
    'doc' => 'doc.png',
    'php' => 'php.png',
    'css' => 'css.png',
    'json'=>'json.png',
    '' => 'folder.png',
    'html' => 'html.png',
    'js' => 'javascript.png',
    'pdf' => 'pdf.png',
    'png' => 'png.png',
    'jpg' => 'png.png',
    'gif' => 'png.png',
    'ppt' => 'ppt.png',
    'unknown' => 'unknown.png',
    'zip' => 'zip.png'
);

$result = array();

foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        $isDirectory = is_dir($directory . '/' . $file);

        // Extract file extension and convert to lowercase
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        // Debugging: Print file name and extension
        // echo "File: $file, Extension: $extension\n";

        // Get the corresponding icon or use 'unknown.png' if not found
        $icon = isset($icons[$extension]) ? $icons[$extension] : 'unknown.png';

        $result[] = array('name' => $file,'extension'=>$extension, 'icon' => $icon, 'isDirectory' => $isDirectory);
    }
}

echo json_encode($result);

// foreach($result as $file_icon){
//     echo $file_icon['icon']."<br>";
// }



// csv.png
// doc.png
// folder.png
// html.png
// javascript.png
// pdf.png
// png.png
// ppt.png
// unknown.png
// zip.png
