<?php 
session_start();
 if (!empty($_SESSION['nama']) and !empty($_SESSION['level']) and !empty($_SESSION['id'])){ 
 header("location: home.php"); } 
 if(!empty($_GET['pass'])){ ?> <script type='text/javascript'> alert('Pengguna tidak terdaftar !'); </script> <?php }
 ?> 

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login User</title>
<link href="home/assets/css/bootstrap.css" rel="stylesheet" media="screen">
</head>

<body>
<div class="col-md-5 col" style="margin-top:15%; margin-left:32%; margin-right:auto; margin-bottom:auto;">
<form role="form" class="col-sm-10 well form-horizontal" action="home/cek_login.php" method="post">
    <fieldset>
    <legend class="col-sm-12" style="color:#999; text-shadow:#333">Login</legend>
    <div class="form-group">
        <label style="color:#666;" for="nis" class="control-label col-md-4">Username :</label>
        <div class="col-sm-6">

            <input type="text" class="form-control input-sm" name="user" placeholder="Username" required>
        </div>
        </div>
        <div class="form-group">
        <label style="color:#666;" for="pass" class="control-label col-md-4">Password :</label><div class="col-sm-6">
            <input type="password" class="form-control input-sm" name="pass" placeholder="Password" required>             
        </div>
        </div>
        
        <div class="col-md-offset-6"><button type="submit" class="btn btn-primary">Masuk</button>
                    
        </div>
    </fieldset>
</form>
</div>
</body>
</html>
