<style>
         body{
            /* background-color:#e1e1e1; */
            background-color:#f0f0f0;
        }
/*
        .header{
            background-color: #63c065;
            position: fixed;
            top:0;
            left:0;
            right:0;
            padding-top:10px;
            padding-bottom:10px;
            color:#fff;
            padding-left:10px;
            padding-right:10px;
        }

        .header > span {
            font-size: 20px;
            font-weight: 800;
        } */


        .side_nav_bar{
            min-height: 94vh;
            background-color:#fff;
            min-width: 180px;
            transition: all 0.3s;
            z-index: 1;
        }



        .menu_icon{
            display: inline-flex;
            width: 25px;
            /* background: aquamarine; */
            justify-content: center;
        }

        .nav-link{
            padding-left:15px;
            padding-right:20px;
            cursor:pointer;
        }

        .menu_items:hover{
            background-color:#d0d0d0;
        }
        .navbar-toggler,
        .navbar-toggler:focus,
        .navbar-toggler:active,
        .navbar-toggler-icon:focus {
            outline: none;
            border: none;
            box-shadow: none;
        }


        #path_beardcrum{
            background-color: #c7c7c7;
            padding-top: 15px;
            padding-bottom: 3px;
            padding-left: 20px;
            padding-right: 20px;
        }

        @media (max-width: 991px) {
            .side_nav_bar{
                margin-left: -180px;
                transition: all 0.3s;
                position: absolute;
                left:0;
            }
        }

        .function_disable{
            color: gray;
        }

</style>


<div style="">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand"  href="./">File Manager</a>
        <button class="navbar-toggler" type="button"   aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">
        <!-- <span class="navbar-toggler-icon"></span> -->
        <div id='menu_icon_open'  onclick="open_side_nav()">
            <i class="fas fa-bars"> </i>
        </div>
        <div id='menu_icon_close' style="display:none;" onclick="close_side_nav()">
            <i class="fas fa-times"> </i>
        </div>
        </button>
        <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        </ul>
        <ul class="navbar-nav d-flex">
                <div class="position-relative" style="cursor:pointer;">
                    <!-- <i class="fas fa-cog"> </i> -->
                    
                </div>
        </ul>


        </div>
    </div>

    </nav>

    <nav aria-label="breadcrumb" id="path_beardcrum">
        <div class="row">
            <div class="col-sm">
                <ol class="breadcrumb" id="path_beardcrum_child"></ol>
            </div>
            <!-- <div class="col-sm-1">
            </div> -->
            <div class="col-md-2">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search" oninput="handleSearchInput(this)">
                <input type="text" style="display:none;" class="form-control" id="folder_path" placeholder="Path">
            </div>
        </div>
    </nav>
</div>

<script>
    var sideNavBar = document.querySelector('.side_nav_bar');

    function open_side_nav(){
        document.getElementById('menu_icon_open').style.display='none';
        document.getElementById('menu_icon_close').style.display='block';
        document.querySelector('.side_nav_bar').style.left = '177px';
    }

    function close_side_nav(){
        document.getElementById('menu_icon_open').style.display='block';
        document.getElementById('menu_icon_close').style.display='none';
        document.querySelector('.side_nav_bar').style.removeProperty('left');
    }
</script>

<div class="d-flex">

<div class="side_nav_bar">
    <div class="side_menu">
        <ul class="navbar-nav" style="overflow-y: scroll;height: 130px;">
            <li class="menu_items">
                <a class="nav-link" onclick="getDirectory('');close_side_nav()">
                <div class="menu_icon"><i class="fas fa-home"></i></div> Home
                </a>
            </li>
             <li class="menu_items">
                <a class="nav-link" onclick="getDirectory('/playground');close_side_nav()">
                    <div class="menu_icon"><i class="fas fa-rocket"></i></div> Playground
                </a>
            </li>
            <li class="menu_items function_disable">
                <a class="nav-link" onclick="close_side_nav()">
                    <div class="menu_icon"><i class="fas fa-plus-square"></i></div> Add Shortcut
                </a>
            </li>
        </ul>
            <hr>
        <ul class="navbar-nav">
            <li class="menu_items">
                <a class="nav-link" onclick="close_side_nav()" data-bs-toggle="modal" data-bs-target="#uploadfilemodel">
                    <div class="menu_icon"><i class="fas fa-upload"></i></div> Upload
                </a>
            </li>
            <li class="menu_items">
                <a class="nav-link" onclick="close_side_nav()" data-bs-toggle="modal" data-bs-target="#newfoldermodel">
                    <div class="menu_icon"><i class="fas fa-folder-plus"></i></div> New Folder
                </a>
            </li>
            <li class="menu_items">
                <a class="nav-link" id="rename_btn_nav" style="pointer-events: none; color:grey;" onclick="close_side_nav()" data-bs-toggle="modal" data-bs-target="#renamemodel">
                    <div class="menu_icon"><i class="fas fa-feather"></i></div> Rename
                </a>
            </li>
            <li class="menu_items function_disable">
                <a class="nav-link" onclick="close_side_nav()">
                    <div class="menu_icon"><i class="fas fa-copy"></i></div> Copy
                </a>
            </li>
            <li class="menu_items function_disable">
                <a class="nav-link" onclick="close_side_nav()">
                    <div class="menu_icon"><i class="fas fa-people-carry"></i></div> Move
                </a>
            </li>
            <li class="menu_items function_disable">
                <a class="nav-link" onclick="close_side_nav()">
                    <div class="menu_icon"><i class="fas fa-paste"></i></div> paste
                </a>
            </li>
            <li class="menu_items">
                <a class="nav-link" id="delete_btn_nav" style="pointer-events: none; color:grey;" onclick="close_side_nav()"  data-bs-toggle="modal" data-bs-target="#deletemodel">
                    <div class="menu_icon"><i class="fas fa-trash"></i></div> Delete
                </a>
            </li>
        </ul>
            <hr>
        <ul class="navbar-nav">
            <li class="menu_items function_disable">
                <a class="nav-link" onclick="close_side_nav()">
                    <div class="menu_icon"><i class="fas fa-book"></i></div> logs
                </a>
            </li>
            <li class="menu_items function_disable">
                <a class="nav-link" onclick="close_side_nav()">
                    <div class="menu_icon"><i class="fas fa-user"></i></div> My Account
                </a>
            </li>
            <li class="menu_items">
                <a class="nav-link" onclick="window.location.href='./auth/logout';close_side_nav()">
                    <div class="menu_icon"><i class="fas fa-sign-out-alt"></i></div> logout
                </a>
            </li>
            <!--<li class="menu_items">
                <a class="nav-link" href="./devices.php">
                <div class="menu_icon"><i class="fas fa-user"></i></div> My Account
                </a>
            </li>
            <li class="menu_items">
                <a class="nav-link" href="./devices.php">
                <div class="menu_icon"><i class="fas fa-book"></i></div> Documentation
                </a>
            </li>
            <li class="menu_items">
                <a class="nav-link" href="./devices.php">
                <div class="menu_icon"><i class="fas fa-sign-out-alt"></i></div> Logout
                </a>
            </li> -->
        </ul>
        <hr>
        <!-- <div style="padding-left:15px; padding-right:10px;">
            <h6>Details</h6>
            <table style="width:100%;">
                <tr>
                    <th>Name</th>
                    <td style="text-align:right;" id="details_file_name">Home</td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td style="text-align:right;" id="details_file_size">100MB</td>
                </tr>
                <tr>
                    <th>No of files</th>
                    <td style="text-align:right;" id="details_no_of_files">32</td>
                </tr>
            </table>
        </div> -->
    </div>
</div>
<div class="container-fluid" style="margin-top:15px;">