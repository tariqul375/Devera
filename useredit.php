<?php
session_start();
if(empty($_SESSION["username"]))
{
  header('Location: login.php');
}
require 'connection.php';
$email = $_SESSION["email"];
$user_id = 0;
$username=$_SESSION["username"] ;
$password="";
$fullname="";
$search_user= "select * from userinfo where email='$email'";
$result_user = $conn->query($search_user);
if ($result_user->num_rows > 0) {
  while($row_user = $result_user->fetch_assoc()) {
    $user_id = $row_user['userinfo_id'];
    $password = $row_user['password'];
    $fullname = $row_user['fullname'];
  }
}
$msg="";
if(isset($_POST['submit']))
{
  $fullname= $_POST['fullname'];
  $username= $_POST['username'];
  $email= $_POST['email'];
  $password =$_POST['password'];
  $update_info ="UPDATE `userinfo` SET `fullname`='$fullname',`username`='$username',`email`='$email',`password`='$password' WHERE userinfo_id = '$user_id'";
  if ($conn->query($update_info) === TRUE) {
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;
        $msg="successfully updated";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>DevEra</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<script>$(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop( true, true ).slideDown("fast");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop( true, true ).slideUp("fast");
            $(this).toggleClass('open');       
        }
    );
});
</script>
<style>
.navbar {
   background-color: #2F4F4F;
}

.navbar li a, .navbar .navbar-brand { 
    color: #d5d5d5 ;
}

.navbar .navbar-nav li a {
    color: #F8F8F8 ;
}

.navbar li a, .navbar .navbar-brand:hover { 
    color: #FFFF00 ;
}

.navbar .navbar-nav li a:hover {
    color: #F8F8F8;
}
  
.carousel{
    margin-top: 0px;
    margin-bottom: 0px;
    padding-top: 0px;
    padding-bottom: 0px;
}

.dropdown-menu li a{
 color: black !important;
}
#contact{
  background-color: grey;
}

footer {
      background-color: #2d2d30;
      color: #f5f5f5;
      padding: 32px;
}

a{
  cursor: pointer;
  text-decoration: none !important;
}

#video{
  cursor: pointer;
}

</style>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="home.php">DevEra</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="#"  class="dropdown-toggle" data-toggle="dropdown">
          Category<span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <?php
              $show_category ="select * from video_category";
              $result = $conn->query($show_category);
              if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
              ?>
              <li><a href="categoryvideo.php?id=<?php echo $row['category_id'] ?>"><?php echo $row['category_name'] ?></a><li>
               <?php
                }
              }
            ?>
          </ul>
      </li>
      <li class="dropdown">
        <a href="#"  class="dropdown-toggle" data-toggle="dropdown">
          <?php echo $_SESSION["username"] ?><span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <?php 
          if($_SESSION["username"]=='admin')
          {
          ?>
          <li><a href="admin.php">profile</a></li>
          <?php
          }else{
          ?>
          <li><a href="userprofile.php">profile</a></li>
          <?php 
            }
          ?>
          <li><a href="logout.php">Log Out</a></li>
          </ul>
      </li>
    </ul>
    </div>
  </div>
</nav>

<div class="container" style="margin-top: 70px">
  <div class="row">
    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"></div>
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 well">
    <?php
          if(isset($_POST['submit']))
          { 
          ?>
          <div class="alert alert-success alert-dismissible fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <?php echo $msg;?>
          </div>
          <?php
          }
    ?>
    <center><h3>Update Profile</h3></center>
    <form action="useredit.php" method="post">
      <div class="form-group">
        <label for="fullname">Full Name:</label>
        <input type="text" class="form-control" id="fullname" placeholder="Update Fullname" name="fullname" value="<?php echo $fullname ?>">
      </div>
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" placeholder="Update username" name="username" value="<?php echo $username ?>">
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" class="form-control" id="email" placeholder="update email" name="email" value="<?php echo $email ?>">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" placeholder="update password" name="password" value="<?php echo $password ?>">
        <input type="checkbox" onclick="myFunction()"> &nbsp;Show Password
      </div>    
      <input type="submit" class="btn btn-primary pull-right" name="submit" value="update">
    </form>
    </div>
    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2"></div>
  </div>
</div>

</body>
</html>
<script type="text/javascript">
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>