<?php
$error="";
if($_REQUEST){
    if(isset($_POST['email'])){
        $email=$_POST['email'];
        $password=$_POST['password'];

        if($email=="admin"){
            if($password=="admin"){
                setcookie("fm_email", $email, time()+(3600*24*2), '/'); 
                header("Location: ../");
            }else{
                $error="Password Wrong";
            }
        }else{
            $error="Incorrect Email ID";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../library/bootstrap.min.css">
    <style>
         body{
            background-color:#f8f6f6;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col"></div>
            <div class="col">
                <h4>Login</h4>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="email_id" class="form-label">Email ID</label>
                        <input type="text" class="form-control" id="email_id" name="email" placeholder="XXXXX@XXXX.XXX" value="admin">
                    </div>
                    <div class="mb-3">
                        <label for="password_id" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password_id" name="password" placeholder="XXXXXXXXX">
                    </div>
                    <span style="color:red;"><?php echo $error;?></span>
                    <div class="mb-3 mt-3">
                        <input type="submit" class="btn btn-secondary btn-sm" value="Login" id="password_id" placeholder="XXXXXXXXX">
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
   
    <script src="../library/bootstrap.bundle.min.js"></script>
</body>
</html>