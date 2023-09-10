<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/fonts.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>MySpace</title>
    <style>
        body{
            background-color:rgb(4 10 18);
        }

        .header_back{
            position: absolute;
            width: 100%;
            height: 313px;
            left: -156px;
            top: -57px;
            background: linear-gradient(143.15deg, rgb(181 0 0 / 27%) -22.54%, rgb(16 115 102 / 30%) 93.59%);
            filter: blur(120.5px);
            z-index: -1;
        }

        /* .box {
            display: flex;
            flex-wrap: wrap;
        }

        .box>* {
            flex: 1 1 160px;     
        } */


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

        .box {
                padding: 1rem;
                display: grid;
                gap: 0.1rem;
                grid-template-columns: repeat(auto-fit, minmax(min(10rem, 100%), 1fr));
            }

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
</head>
<body>
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
          <a class="navbar-brand text-white" href="./">MySpace</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              
            </ul>
            <form class="d-flex" action="" method="get">
              <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
            </form>
          </div>
        </div>
    </nav>
    <div class="header_back"></div>

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
    ?>

    <div style="color: #fff;">
            <div class="container-fluid">
                <span class="tab_nav" onclick="window.location.href='./'">Home</span> / 
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

    <div style="color: #fff;">
      <?php


      $dir = new DirectoryIterator("./".$path);
      
      $html_code='<div class="box">';
      foreach ($dir as $fileinfo) {
          if ($fileinfo->isDir() && !$fileinfo->isDot()) {
              // $html_code.='<div class="item" onclick="window.location.href=\''.$fileinfo->getFilename().'\'"><img src="folder.png" style=" height: 50px;"><br>'.$fileinfo->getFilename().'</div>';
              // $html_code1='\'<div class="item" onclick="window.location.href=\''.$fileinfo->getFilename().'\'"><img src="folder.png" style=" height: 50px;"><br>'.$fileinfo->getFilename().'</div>\'';
              
              if(stristr($fileinfo->getFilename(), $search_text)){

                if($fileinfo->getFilename()=='icons_index' || $fileinfo->getFilename()=='.git'){
                    continue;
                }

                  $parent_path=''.$path.'/'.$fileinfo->getFilename().'';
                  $html_code.='<div class="item" onclick="window.location.href=\'?path='.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/folder.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                  // $html_code.='<div class="item" onclick="window.location.href=\'?path='.$fileinfo->getFilename().'\'"><img src="./icons_index/folder.png" style=" height: 50px;"><br>'.$fileinfo->getFilename().'</div>';
              }else{
                  // $html_code.='<div class="item" onclick="window.location.href=\''.$fileinfo->getFilename().'\'"><img src="folder.png" style=" height: 50px;"><br>'.$fileinfo->getFilename().'</div>';
              }

          }else{
              $ext = pathinfo($path.'/'.$fileinfo->getFilename(), PATHINFO_EXTENSION);

              if($fileinfo->getFilename()=='default.php'){
                continue;
              }

              if($fileinfo->getFilename()=="index.php" || $fileinfo->getFilename()=="index.html"){
                  if($path!=""){
                      // header('Location:'.$path.'/'.$fileinfo->getFilename());
                      echo "<script>window.open('".$path.'/'.$fileinfo->getFilename()."');</script>";
                  }
              }

              if($ext=="php"){
                  if(stristr($fileinfo->getFilename(), $search_text)){
                      $html_code.='<div class="item" onclick="window.location.href=\'.'.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/php.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                 }
              }elseif($ext=="png" || $ext=="jpg" || $ext=="JPG"|| $ext=="svg"|| $ext=="webp"){
                  if(stristr($fileinfo->getFilename(), $search_text)){
                      // $html_code.='<div class="item" onclick="window.location.href=\'.'.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/png.png" style=" height: 50px;"><br>'.$fileinfo->getFilename().'</div>';
                      $html_code.='<div class="item" onclick="window.location.href=\'.'.$path.'/'.$fileinfo->getFilename().'\'"><img src="./'.$path.'/'.$fileinfo->getFilename().'" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                 }
              }elseif($ext=="csv"){
                  if(stristr($fileinfo->getFilename(), $search_text)){
                      $html_code.='<div class="item" onclick="window.location.href=\'.'.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/csv.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                  }
              }elseif($ext=="zip"){
                  if(stristr($fileinfo->getFilename(), $search_text)){
                      $html_code.='<div class="item" onclick="window.location.href=\'.'.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/zip.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                  }
              }elseif($ext=="html"){
                  if(stristr($fileinfo->getFilename(), $search_text)){
                      $html_code.='<div class="item" onclick="window.location.href=\'.'.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/html.png" style=" height: 50px;"><br><span class="title_item" title="C:/xampp/htdocs/'.$path.$fileinfo.'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                  }
              }elseif($ext=="css"){
                  if(stristr($fileinfo->getFilename(), $search_text)){
                      $html_code.='<div class="item" onclick="window.location.href=\'.'.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/html.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                  }
              }elseif($ext=="js"){
                  if(stristr($fileinfo->getFilename(), $search_text)){
                      $html_code.='<div class="item" onclick="window.location.href=\'.'.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/javascript.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                  }
              }elseif($ext=="pdf"){
                  if(stristr($fileinfo->getFilename(), $search_text)){
                      $html_code.='<div class="item" onclick="window.location.href=\'.'.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/pdf.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                  }
              }elseif($ext=="pptx"){
                  if(stristr($fileinfo->getFilename(), $search_text)){
                      $html_code.='<div class="item" onclick="window.location.href=\'.'.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/ppt.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                  }
              }elseif($ext=="doc" || $ext=="docx"){
                  if(stristr($fileinfo->getFilename(), $search_text)){
                      $html_code.='<div class="item" onclick="window.location.href=\'.'.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/doc.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';
                  }
              }


              else{
                  if(stristr($fileinfo->getFilename(), $search_text)){
                    if(file_name_trim($fileinfo->getFilename())=='.' || file_name_trim($fileinfo->getFilename())=='..'){continue;}
                      $html_code.='<div class="item" onclick="window.location.href=\'.'.$path.'/'.$fileinfo->getFilename().'\'"><img src="./icons_index/unknown.png" style=" height: 50px;"><br><span class="title_item" title="'.$fileinfo->getFilename().'">'.file_name_trim($fileinfo->getFilename()).'</span></div>';

                    //   $html_code.='<div class="item" onclick="window.location.href=\'.'.$path.'/'.$fileinfo->getFilename().'\'"><span class="title_item">'.$fileinfo->getFilename().'</span></div>';
                  }
              }
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>