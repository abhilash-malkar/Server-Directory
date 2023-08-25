<?php
session_start();

$files=array();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server</title>
    <link rel="shortcut icon" href="./icons_index/server_icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>

</head>

<style>
    body {
        /* background-color: #474E68; */
        background-color: #251B37;
        color: #fff;

    }

    .box {
        display: flex;
        flex-wrap: wrap;
    }

    .box>* {
        flex: 1 1 160px;     
    }


    .item {
        min-height: 120px;
        min-width: 120px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        border-radius: 8px;
        margin: 5px;
        padding: 10px;
        display: flex;
        flex-direction: column;
        -webkit-box-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        align-items: center;
    } 

    /* .box {
            padding: 1rem;
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(min(10rem, 100%), 1fr));
        } */

    .title_item{
        inline-size: 150px;
        overflow-wrap: break-word;
        text-align: center;
    }

    .item:hover {
        background-color: #123424;
        background: rgba(255, 255, 255, 0.6);
        cursor: pointer;
    }



    .topnav {
        overflow: hidden;
        /* background-color: #404258; */
        background-color: #372948;
        position: fixed;
        /* position: sticky; */
        top: 0%;
        left: 0%;
        right: 0%;
    }

    .topnav a {
        float: right;
        color: #f2f2f2;
        text-align: center;
        padding: 18px 20px;
        text-decoration: none;
        font-size: 17px;
    }

    .topnav a:hover {
        /* background-color: #04AA6D; */
        background-color: rgba(255, 255, 255, 0.6);
        color: black;
    }

    .topnav a.active {
        background-color: #04AA6D;
        color: white;
    }

    .h1_text {
        margin-left: 20px;
        /* Creates space on the outside of the element */
        color: #FFF;
        font-size: 2vw;
        font-family: 'Times New Roman';
        margin-top: 10px;
        margin-bottom: -6px;
        cursor: pointer;
        /* padding-top: 10px; */
        padding-bottom: 10px;
    }

    ::-webkit-scrollbar {
        width: 0px;
        background: transparent; /* make scrollbar transparent */
    }

    .tab_nav{
        padding: 1px;
        border-radius: 5px;
        padding-left: 10px;
        padding-right: 10px;
    }

    .tab_nav:hover{
        background-color: #123424;
        background: rgba(255, 255, 255, 0.6);
        cursor: pointer;
    }
</style>

<body>
    <br>
    <br>
    <br>
    <br>
    <div class="container">
        <?php
            $search_text="";
            $path="";
            if ($_SERVER["REQUEST_METHOD"]==="GET") {
                if(isset($_REQUEST['search'])){
                    $search_text = $_REQUEST['search'];
                }else{
                    $search_text="";
                }
                $parent_path="";
                if(isset($_REQUEST['path'])){
                    $path=$_REQUEST['path'];
                    
                }else{
                    $path="";
                }
            }

            $dir = new DirectoryIterator("./".$path);
            $html_code='<div class="box">';
            foreach ($dir as $fileinfo) {
                if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                    // $html_code.='<div class="item" onclick="window.location.href=\''.$fileinfo->getFilename().'\'"><img src="folder.png" style=" height: 50px;"><br>'.$fileinfo->getFilename().'</div>';
                    // $html_code1='\'<div class="item" onclick="window.location.href=\''.$fileinfo->getFilename().'\'"><img src="folder.png" style=" height: 50px;"><br>'.$fileinfo->getFilename().'</div>\'';
                    
                    if(stristr($fileinfo->getFilename(), $search_text)){
                        $parent_path=''.$path.'/'.$fileinfo->getFilename().'';
                        $html_code.='<div class="item" onclick="window.location.href=\'?path='.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/folder.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                        // $html_code.='<div class="item" onclick="window.location.href=\'?path='.$fileinfo->getFilename().'\'"><img src="./icons_index/folder.png" style=" height: 50px;"><br>'.$fileinfo->getFilename().'</div>';
                    }else{
                        // $html_code.='<div class="item" onclick="window.location.href=\''.$fileinfo->getFilename().'\'"><img src="folder.png" style=" height: 50px;"><br>'.$fileinfo->getFilename().'</div>';
                    }

                }else{
                    $ext = pathinfo($path.'/'.$fileinfo->getFilename(), PATHINFO_EXTENSION);

                    if($fileinfo->getFilename()=="index.php" || $fileinfo->getFilename()=="index.html"){
                        if($path!=""){
                            // header('Location:'.$path.'/'.$fileinfo->getFilename());
                            echo "<script>window.open('".$path.'/'.$fileinfo->getFilename()."');</script>";
                        }
                    }

                    if($ext=="php"){
                        if(stristr($fileinfo->getFilename(), $search_text)){
                            $html_code.='<div class="item" onclick="window.location.href=\''.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/php.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                       }
                    }elseif($ext=="png" || $ext=="jpg" || $ext=="JPG"|| $ext=="svg"){
                        if(stristr($fileinfo->getFilename(), $search_text)){
                            // $html_code.='<div class="item" onclick="window.location.href=\''.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/png.png" style=" height: 50px;"><br>'.$fileinfo->getFilename().'</div>';
                            $html_code.='<div class="item" onclick="window.location.href=\''.$path.'/'.$fileinfo->getFilename().'\'"><img src="./'.$path.'/'.$fileinfo->getFilename().'" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                       }
                    }elseif($ext=="csv"){
                        if(stristr($fileinfo->getFilename(), $search_text)){
                            $html_code.='<div class="item" onclick="window.location.href=\''.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/csv.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                        }
                    }elseif($ext=="zip"){
                        if(stristr($fileinfo->getFilename(), $search_text)){
                            $html_code.='<div class="item" onclick="window.location.href=\''.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/zip.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                        }
                    }elseif($ext=="html"){
                        if(stristr($fileinfo->getFilename(), $search_text)){
                            $html_code.='<div class="item" onclick="window.location.href=\''.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/html.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                        }
                    }elseif($ext=="css"){
                        if(stristr($fileinfo->getFilename(), $search_text)){
                            $html_code.='<div class="item" onclick="window.location.href=\''.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/html.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                        }
                    }elseif($ext=="js"){
                        if(stristr($fileinfo->getFilename(), $search_text)){
                            $html_code.='<div class="item" onclick="window.location.href=\''.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/javascript.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                        }
                    }elseif($ext=="pdf"){
                        if(stristr($fileinfo->getFilename(), $search_text)){
                            $html_code.='<div class="item" onclick="window.location.href=\''.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/pdf.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                        }
                    }elseif($ext=="pptx"){
                        if(stristr($fileinfo->getFilename(), $search_text)){
                            $html_code.='<div class="item" onclick="window.location.href=\''.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/ppt.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                        }
                    }elseif($ext=="doc" || $ext=="docx"){
                        if(stristr($fileinfo->getFilename(), $search_text)){
                            $html_code.='<div class="item" onclick="window.location.href=\''.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/doc.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                        }
                    }


                    // else{
                    //     if(stristr($fileinfo->getFilename(), $search_text)){
                    //         $html_code.='<div class="item" onclick="window.location.href=\''.$path.'/'.$fileinfo->getFilename().'\'"><span class="title_item">'.$fileinfo->getFilename().'</span></div>';
                    //     }
                    // }
                }

            }
            $html_code.='</div>';

            echo $html_code;
            

            function file_name_trim($text){
                if (strlen($text) > 16) {
                    return substr($text, 0, 16) . "...";
                } else {
                    return $text;
                }
            }
        ?>
    </div>



    <div class="topnav" style="font-family:'Times New Roman';">
        <form action="" method="get">
            <input type="text" name="path" value="<?php echo $path; ?>"  style="display: none;">
            <input style="float: right; position:relative; margin-top:10px; margin-right:10px;" placeholder="Search" type="search" name="search" id="search_txt">
            <input type="submit" value="Submit" style="display: none;">
        </form>
        <span  onclick="window.location.href='index.php';">  <span class="h1_text"><img src="./icons_index/server.png" width="3%" alt="">Server</span> </span>
        <div style="background-color: #7A4069;">
            <div class="container">
                <span class="tab_nav" onclick="window.location.href='./index.php'">Home</span> / 
                <?php 
                    $list_="";
                    $p=explode("/",$path);
                    for($i=1;$i<count($p);$i++){
                        $list_.="/".$p[$i];
                        echo "<span class='tab_nav' onclick='window.location.href=\"?path=".$list_."\"'>".$p[$i]."</span> / ";
                    }

                ?>
            </div>
        </div>
    </div>
    

    <script></script>

</body>

</html>