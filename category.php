<?php
session_start();
if(empty($_SESSION["username"]))
{
  header('Location: login.php');
}else{
  if($_SESSION["username"] != "admin")
  {
    header('Location: home.php');
  }
}
require 'connection.php';
$msg="";
if(isset($_POST['submit']))
{


$category_name = $_POST['category_name'];

$add_category ="INSERT INTO `video_category`(`category_name`) VALUES ('$category_name')";

  if ($conn->query($add_category) === TRUE) {
    $msg="successfully Added";
  }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>DevEra | Add Category</title>
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

  .input-group{
    border-style: groove;
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
.container{
  margin-top: 80px;
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
        <a href="#"  class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION["username"] ?><span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="admin.php">profile</a></li>
          <li><a href="logout.php">Log Out</a></li>
          </ul>
      </li>
    </ul>
    </div>
  </div>
</nav>

<div class="container">
  <div class="panel panel-default">
    <div class="panel-heading">
      <span class="pull-right"><a href="viewcategory.php">[view All Category]</a></span>
      <p><strong>Upload Video</strong></p>
      
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"></div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 well">
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
           <form action="category.php" method="POST">
            
              <div class="form-group">
                <label for="category_name">Category Name:</label>
                <input type="text" class="form-control" id="category_name" name="category_name" required>
              </div>

              <input type="submit" name="submit" class="btn btn-primary btn-block" value="Add Category">
            </form> 
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"></div>
      </div>
    </div>
  </div>
</div>

	</body>
</html>
