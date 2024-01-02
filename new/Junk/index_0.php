<?php
    $path="";
    if($_REQUEST){
        if(isset($_GET['path'])){
            $path=$_GET['path'];
        }
        else{
            $path="";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-color:#0b141e;
            color:#b9c2cb;
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
    </style>
</head>
<body>
    <h2>Files</h2>
    <div id="list_body">
        <div class="list_item">
            <img class="list_item_icon" src="./icons_index/folder.png">
            <div>File name</div>
        </div>
        
    </div>

    <div id="list_body"></div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function(){
            $.ajax({
                url: './data_handle/getRootDirectory.php',
                type: 'GET',
                data: {'path': '<?php echo $path; ?>'},
                dataType: 'json',
                success: function(data){
                    data.forEach(function(item){
                        var listItem = '<div class="list_item">';
                        if(item.isDirectory==true){
                            listItem += '<img class="list_item_icon" onclick="window.location.href=\'?path='+'<?php echo $path; ?>'+'/'+item.name+'\'" src="./icons_index/' + item.icon + '">';
                        }else{
                            listItem += '<img class="list_item_icon" src="./icons_index/' + item.icon + '">';
                        }
                        listItem += '<div title="' + item.name + '"> ' + fileNameTrim(item.name) + '</div>';
                        listItem += '</div>';
                        $('#list_body').append(listItem);
                    });
                }
            });
        });

        function fileNameTrim(text) {
            var len=10;
            if (text.length > len) {
                return text.substring(0, len) + "...";
            } else {
                return text;
            }
        }

    </script>

</body>
</html>