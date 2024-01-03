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

        .modal-header {
            padding: 10px!important;
            font-size: 1rem!important;
        }
        
        .modal-footer {
            padding: 7px!important;
        }
    </style>
</head>
<body>
    <?php include("./templates/header.php")?>

    <div class="container-fluid">
        <div id="list_body"></div>
    </div>

    <!-- models -->
    <!-- new folder -->
    <div class="modal fade" id="newfoldermodel" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLongTitle" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-6" id="exampleModalLongTitle">New Folder</h1>
                <button type="button" class="btn-close fs-6" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="min-height: 10px; overflow: x;">
                <div class="mb-3">
                    <label for="phone_num" class="form-label">Folder Name</label>
                    <input type="text" class="form-control" id="folder_name_text" placeholder="AXXXXXX">
                </div>
                <div id="newfoldermodel_error" style="color: red;font-weight: 500;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" id="close_newfoldermodel">Close</button>
                <button type="submit" class="btn btn-primary btn-sm" onclick="create_new_folder()">Create</button>
            </div>
            </div>
        </div>
    </div>
    <!-- new folder -->
    <!-- upload model -->
    <div class="modal fade" id="uploadfilemodel" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLongTitle" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-6" id="exampleModalLongTitle">Upload file</h1>
                <button type="button" class="btn-close fs-6" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="min-height: 10px; overflow: x;">
                <div class="mb-3">
                    <label for="fileUpload" class="form-label">Upload</label>
                    <input type="file" class="form-control form-control-sm" id="fileUpload" multiple>
                </div>
                <div class="progress" style="display:none;"  id="upload-progress-bar-parent" role="progressbar" aria-label="Example with label" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar" id="upload-progress-bar" style="width: 0%">0%</div>
                </div>
                <div id="uploadfilemodel_error" style="color: red;font-weight: 500;"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" id="close_uploadfilemodel">Close</button>
                <button type="submit" class="btn btn-primary btn-sm" onclick="uploadFile()">Upload</button>
            </div>
            </div>
        </div>
    </div>
    <!-- upload model -->
    <!-- delete model -->
    <div class="modal fade" id="deletemodel" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLongTitle" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-6" id="exampleModalLongTitle">Delete</h1>
                <button type="button" class="btn-close fs-6" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="min-height: 10px; overflow: x;">
                <div class="mb-0">
                    <label class="form-label">Do want to delete?</label>
                </div>
                <div id="deletemodel_error" style="color: red;font-weight: 500;"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" id="close_deletemodel">Close</button>
                <button type="submit" class="btn btn-danger btn-sm" onclick="delete_selected()">Delete</button>
            </div>
            </div>
        </div>
    </div>
    <!-- delete model -->
    <!-- rename model -->
    <div class="modal fade" id="renamemodel" tabindex="-1" data-bs-backdrop="static" aria-labelledby="renamemodelModalLongTitle" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-6" id="renamemodelModalLongTitle">Rename</h1>
                <button type="button" class="btn-close fs-6" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="min-height: 10px; overflow: x;">
                <!-- <div class="mb-0">
                    <label for="phone_num" class="form-label">Rename</label>
                    <input type="text" class="form-control" id="file_rename_text" placeholder="AXXXXXX">
                </div> -->
                <label for="file_rename_text" class="form-label">Rename</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="file_rename_text"  placeholder="AXXXXXX" aria-label="Rename" aria-describedby="file_rename_extension">
                    <span class="input-group-text" id="file_rename_extension">s</span>
                </div>
                <div id="renamemodel_error" style="color: red;font-weight: 500;"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" id="close_renamemodel">Close</button>
                <button type="submit" class="btn btn-dark btn-sm" onclick="rename_selected()">Save</button>
            </div>
            </div>
        </div>
    </div>    
    <!-- rename model -->
    <!-- models -->


    <?php include("./templates/footer.php")?>


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


        function uploadFile() {
            var fileInput = document.getElementById('fileUpload');
            let path = document.getElementById("folder_path").value;
            
            document.getElementById('upload-progress-bar-parent').style.display = "block";
            var files = fileInput.files;

            if (files.length > 0) {
                var formData = new FormData();
                formData.append('path', path);

                for (var i = 0; i < files.length; i++) {
                    formData.append('files[]', files[i]);
                }

                var xhr = new XMLHttpRequest();

                xhr.upload.addEventListener('progress', function (event) {
                    if (event.lengthComputable) {
                        var percent = Math.round((event.loaded / event.total) * 100);
                        var progressBar = document.getElementById('upload-progress-bar');
                        progressBar.style.width = percent + '%';
                        progressBar.innerHTML = percent + '%';
                    }
                });

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success === true) {
                                getDirectory(path);
                                
                                setTimeout(() => {
                                    document.getElementById("fileUpload").value = null;
                                    var percent = 0;
                                    var progressBar = document.getElementById('upload-progress-bar');
                                    progressBar.style.width = percent + '%';
                                    progressBar.innerHTML = percent + '%';
                                    document.getElementById('upload-progress-bar-parent').style.display = "none";
                                    document.getElementById("close_uploadfilemodel").click();
                                }, 500);

                            } else {
                                document.getElementById('upload-progress-bar-parent').style.display = "none";
                                document.getElementById("uploadfilemodel_error").innerHTML = response.message;
                                console.error('Upload failed:', response.message);

                                setTimeout(() => {
                                    document.getElementById("fileUpload").value = null;
                                    document.getElementById("uploadfilemodel_error").innerHTML ="";
                                    var percent = 0;
                                    var progressBar = document.getElementById('upload-progress-bar');
                                    progressBar.style.width = percent + '%';
                                    progressBar.innerHTML = percent + '%';
                                    document.getElementById("close_uploadfilemodel").click();
                                }, 5000);
                            }
                        } else {
                            console.error('Failed to upload file. HTTP status:', xhr.status);
                        }
                    }
                };

                xhr.open('POST', './data_handle/upload_file.php', true);
                xhr.send(formData);
            }
        }

        setInterval(() => {
            // enable delete button
            if(selectedItems.length>0){
                document.getElementById("delete_btn_nav").style.color="#000";
                document.getElementById("delete_btn_nav").style.pointerEvents="auto";
            }else{
                document.getElementById("delete_btn_nav").style.color="grey";
                document.getElementById("delete_btn_nav").style.pointerEvents="none";  
            }

            //enable rename name
            if(selectedItems.length==1){
                document.getElementById("rename_btn_nav").style.color="#000";
                document.getElementById("rename_btn_nav").style.pointerEvents="auto";
                
                var pathArrays = selectedItems[0].split('/');
                var pathLens=pathArrays.length-1;
                var pathExtensions=pathArrays[pathLens].split('.');
                document.getElementById("renamemodelModalLongTitle").innerHTML="Rename "+pathArrays[pathLens];

                if(pathExtensions[1]!=null){
                    document.getElementById("file_rename_extension").innerHTML="."+pathExtensions[1];
                }else{
                    document.getElementById("file_rename_extension").innerHTML="Folder";
                }

            }else{
                document.getElementById("rename_btn_nav").style.color="grey";
                document.getElementById("rename_btn_nav").style.pointerEvents="none";  
                document.getElementById("renamemodelModalLongTitle").innerHTML="Rename";
            }


        }, 500);


        function delete_selected(){
            let path = document.getElementById("folder_path").value;
            $.ajax({
                type: "POST",
                url: "./data_handle/delete_files.php", // Replace with the actual path to your PHP script
                data: { selectedItems: selectedItems },
                success: function(response) {
                    console.log(response); // You can handle the PHP script's response here
                    var bool=true;
                    response.forEach(element => {
                        if(element.success===true){
                            if(bool){
                                getDirectory(path);
                                bool=false;
                            }
                            document.getElementById("close_deletemodel").click();
                        }else{
                            document.getElementById("deletemodel_error").innerHTML+=element.message+"<br>";
                            setTimeout(() => {
                                document.getElementById("deletemodel_error").innerHTML="";
                            }, 5000);
                        }
                    });

                    


                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        function rename_selected(){
            var rename=document.getElementById("file_rename_text").value;
            var file_extension=document.getElementById("file_rename_extension").innerHTML;
            if(file_extension!="Folder"){
                rename+=file_extension;
            }
            let path = document.getElementById("folder_path").value;
            $.ajax({
                type: "POST",
                url: "./data_handle/rename_file.php",
                data: { selectedItems: selectedItems,rename:path+"/"+rename },
                success: function(response) {
                    console.log(response); 
                    if(response.success==true){
                        getDirectory(path);
                        document.getElementById("close_renamemodel").click();
                        document.getElementById("file_rename_text").value = null;
                    }else{
                        document.getElementById("renamemodel_error").innerHTML=response.message;
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });            
        }



    </script>    

    <script src="./library/bootstrap.bundle.min.js"></script>
</body>
</html>