<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
if(isset($_COOKIE['fm_email'])){
    $email=$_COOKIE['fm_email'];
}else{
    // header("./auth/login");
    echo "<script>window.location.href='./auth/login';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>
    <link rel="stylesheet" href="./library/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous">

    <style>
        #list_body {
            transition: all 0.3s;
            font-family: 'Arial', sans-serif;
            margin: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 20px;
        }

        .list_item {
            text-align: center;
            padding: 10px;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 20px;
        }

        .list_item_icon {
            width: 48px;
            height: 48px;
            margin-bottom: 5px;
        }

        .list_item:hover{
            background-color: #93939357;
            border-radius: 20px;
            
        }

        .breadcrumb-item-cursor{
            cursor: pointer;
        }

        .selected {
            background-color: #93939357;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <?php include("./Templates/header.php")?>

    <div class="container-fluid">
        <div id="list_body"></div>
    </div>

    <!-- models -->
    <!-- new folder -->
    <div class="modal fade" id="newfoldermodel" tabindex="-1" aria-labelledby="exampleModalLongTitle" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLongTitle">New Folder</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="min-height: 10px; overflow: x;">
                <div class="mb-3">
                    <label for="phone_num" class="form-label">Folder Name</label>
                    <input type="text" class="form-control" id="folder_name_text" placeholder="AXXXXXX">
                </div>
                <div id="newfoldermodel_error" style="color: red;font-weight: 500;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close_newfoldermodel">Close</button>
                <button type="submit" class="btn btn-primary" onclick="create_new_folder()">Create</button>
            </div>
            </div>
        </div>
    </div>
    <!-- new folder -->
    <!-- models -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        var path="";
        let selectedItems = [];

        function getDirectory(path){
            var pathArray = path.split('/');
            var pathLen=pathArray.length;
            document.getElementById("path_beardcrum_child").innerHTML="";
            var count =1;
            var path_limit="";
            pathArray.forEach(function(element) {
                // console.log(element);
                // <li class="breadcrumb-item"><a href="#">Home</a></li>
                var element_1 = document.createElement("li");

                if(element!=""){
                    path_limit+="/"+element+"";
                }

                if(element==""){
                    element="Home";
                }



                if(count==pathLen){
                    element_1.setAttribute("class","breadcrumb-item active");
                    console.log(path_limit);
                    document.getElementById("folder_path").value=path_limit;
                    
                }else{
                    // console.log(path_limit);
                    element_1.setAttribute("class","breadcrumb-item breadcrumb-item-cursor");
                    element_1.setAttribute("onclick",'getDirectory(\''+path_limit+'\')');
                }
                
                element_1.innerHTML = "<span>"+element+"</span>";
                document.getElementById("path_beardcrum_child").appendChild(element_1);
                count++;

            });

            
            document.getElementById("list_body").innerHTML="";
            $.ajax({
                url: './data_handle/getRootDirectory.php',
                type: 'GET',
                data: {'path': path},
                dataType: 'json',
                success: function(data){
                    data.forEach(function(item){
                        var listItem = '';
                        if(item.isDirectory==true)
                        
                            listItem += '<div class="list_item" onclick="handleItemClick(event, \''+path+'/'+item.name+'\')" ondblclick="getDirectory(\''+path+'/'+item.name+'\')">';   
                        else{
                            listItem += '<div class="list_item" onclick="handleItemClick(event, \''+path+'/'+item.name+'\')" ondblclick="window.open(\''+path+'/'+item.name+'\', \'_blank\').focus()">';
                        }
                        listItem += '<img class="list_item_icon" src="./icons_index/' + item.icon + '">';
                        listItem += '<div title="' + item.name + '"> ' + fileNameTrim(item.name) + '</div>';
                        listItem += '</div>';
                        $('#list_body').append(listItem);
                    });
                    selectedItems=[];
                }
            });
        }

        getDirectory(path);

        function create_new_folder(){
            var folder_name=document.getElementById("folder_name_text").value;
            var folder_path=document.getElementById("folder_path").value;
            if(folder_name==""){
                document.getElementById("newfoldermodel_error").innerHTML="* Folder Name required";
                return;
            }else{
                document.getElementById("newfoldermodel_error").innerHTML="";
            }

            $.ajax({
                url: './data_handle/new_folder.php',
                type: 'GET',
                data: {'path': folder_path+"/"+folder_name},
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    if(data.success==true){
                        getDirectory(folder_path);
                        document.getElementById("folder_name_text").value="";
                        document.getElementById("close_newfoldermodel").click();
                    }
                    if(data.success==false){
                        document.getElementById("newfoldermodel_error").innerHTML=data.message;
                        
                    }
                }
            });
        }

        function fileNameTrim(text) {
            var len=10;
            if (text.length > len) {
                return text.substring(0, len) + "...";
            } else {
                return text;
            }
        }


        

        function handleItemClick(event, path) {
            if (event.ctrlKey || event.metaKey) {
                // Ctrl+click to toggle selection
                const index = selectedItems.indexOf(path);
                if (index === -1) {
                    selectedItems.push(path);
                    event.currentTarget.classList.add('selected');
                } else {
                    selectedItems.splice(index, 1);
                    event.currentTarget.classList.remove('selected');
                }
            } else {
                // Single click to select only the clicked item
                selectedItems = [path];
                const selectedItemsElements = document.querySelectorAll('.list_item.selected');
                selectedItemsElements.forEach(item => item.classList.remove('selected'));
                event.currentTarget.classList.add('selected');
            }
            console.log(selectedItems);

        }

        function handleSearchInput(inputElement) {
            // Get the value of the input field
            const search_query = inputElement.value;
            let path=document.getElementById("folder_path").value;
            // Print the value to the console
            console.log("Search input:", search_query);

            document.getElementById("list_body").innerHTML="";
            $.ajax({
                url: './data_handle/search_files.php',
                type: 'GET',
                data: {'search_query': search_query,'path': path},
                dataType: 'json',
                success: function(data){
                    data.forEach(function(item){
                        var listItem = '';
                        if(item.isDirectory==true)
                        
                            listItem += '<div class="list_item" onclick="handleItemClick(event, \''+path+'/'+item.name+'\')" ondblclick="getDirectory(\''+path+'/'+item.name+'\')">';   
                        else{
                            listItem += '<div class="list_item" onclick="handleItemClick(event, \''+path+'/'+item.name+'\')" ondblclick="window.open(\''+path+'/'+item.name+'\', \'_blank\').focus()">';
                        }
                        listItem += '<img class="list_item_icon" src="./icons_index/' + item.icon + '">';
                        listItem += '<div title="' + item.name + '"> ' + fileNameTrim(item.name) + '</div>';
                        listItem += '</div>';
                        $('#list_body').append(listItem);
                    });
                    selectedItems=[];
                }
            });

        }

    </script>    

    <script src="./library/bootstrap.bundle.min.js"></script>
</body>
</html>