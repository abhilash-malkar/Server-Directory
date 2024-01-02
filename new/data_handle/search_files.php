<?php

$directory = '../../../';
$search_query = "";

if ($_REQUEST) {
    if (isset($_GET['path'])) {
        $directory = '../../../' . $_GET['path'];
        $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : "";
    } else {
        $directory = '../../../';
    }
}

$files = scandir($directory);

$icons = array(
    'csv' => 'csv.png',
    'doc' => 'doc.png',
    'php' => 'php.png',
    'css' => 'css.png',
    'json' => 'json.png',
    '' => 'folder.png',
    'html' => 'html.png',
    'js' => 'javascript.png',
    'pdf' => 'pdf.png',
    'png' => 'png.png',
    'jpg' => 'png.png',
    'gif' => 'png.png',
    'ppt' => 'ppt.png',
    'unknown' => 'unknown.png',
    'zip' => 'zip.png',
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

        // Check if the file name contains the search query
        if (stripos($file, $search_query) !== false) {
            $result[] = array('name' => $file, 'extension' => $extension, 'icon' => $icon, 'isDirectory' => $isDirectory);
        }
    }
}

echo json_encode($result);
?>
