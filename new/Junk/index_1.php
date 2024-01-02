<?php
    // $path="";
    // if($_REQUEST){
    //     if(isset($_GET['path'])){
    //         $path=$_GET['path'];
    //     }
    //     else{
    //         $path="";
    //     }
    // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./library/bootstrap.min.css">
    <style>
        body{
            /* 
            background-color:#0b141e; 
            color:#b9c2cb;
            */
            background-color:#ebedef;
            color:#1b1d1f;
        }

        #list_body {
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

        #path_beardcrum{
            background-color: #ddd;
            padding-top: 15px;
            padding-bottom: 3px;
            padding-left: 20px;
            border-radius: 10px;
            margin-left:5px;
            margin-right:5px;
            
        }

        .breadcrumb-item-cursor{
            cursor: pointer;
        }

    </style>
</head>
<body>

    <div class="container-fluid">
        <h2>Files</h2>


        <nav aria-label="breadcrumb" id="path_beardcrum">
            <ol class="breadcrumb" id="path_beardcrum_child">
                <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Library</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data</li> -->
            </ol>
        </nav>

        <div id="list_body"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        var path="";
        $(document).ready(function(){


        });

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
                }else{
                    console.log(path_limit);
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
                            listItem += '<div class="list_item" onclick="getDirectory(\''+path+'/'+item.name+'\')">';   
                        else{
                            listItem += '<div class="list_item">';
                        }
                        listItem += '<img class="list_item_icon" src="./icons_index/' + item.icon + '">';
                        listItem += '<div title="' + item.name + '"> ' + fileNameTrim(item.name) + '</div>';
                        listItem += '</div>';
                        $('#list_body').append(listItem);
                    });
                }
            });
        }

        getDirectory(path);



        function fileNameTrim(text) {
            var len=10;
            if (text.length > len) {
                return text.substring(0, len) + "...";
            } else {
                return text;
            }
        }

    </script>
    <script src="./library/bootstrap.bundle.min.js"></script>
</body>
</html>