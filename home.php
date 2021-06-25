<?php
session_start();
if(empty($_SESSION["username"]))
{
  header('Location: login.php');
}
require 'connection.php';
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
      <li><a href="#about">About</a></li>
      <li><a href="#contact">Contact</a></li>
    </ul>
    </div>
  </div>
</nav>


<div class="container" style="margin-top:70px">
  <form action="search.php" class="form-inline"  method="post">
  <div class="form-group">
    <label for="email">Search by name</label>
    <input type="text" class="form-control" placeholder="Search" name="search">
  </div>
  <div class="form-group">
    <label for="duration">Filter by Duration</label>
    <select class="form-control" name='duration'>
      <option value="1-5">1-5</option>
      <option value="5-10">5-10</option>
      <option value="10+">10+</option>
    </select>
  </div>
  <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
  </form>
  <br>
</div>
 

<div class="container">
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="item active">
        <img src="image/t.jpeg" alt="Albert Einstein" style="width:1200px; height:470px">
      </div>

      <div class="item">
        <img src="image/steve.png" alt="ambrosebierce1" style="width:1200px; height:470px">
      </div>
    
      <div class="item">
        <img src="image/engineering.jpg" alt="man_computer" style="width:1200px; height:470px">
      </div>
    </div>

    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <br>
</div>


<?php
  $show_category ="select * from video_category";
  $result = $conn->query($show_category);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

  $category_id = $row['category_id'];
  $show_video ="select * from video where category_id =$category_id limit 4";
  $video_result = $conn->query($show_video);
    if ($video_result->num_rows > 0) {
?>

<div class="container">
<legend><?php echo $row['category_name'] ?><span class="pull-right"><a href="categoryvideo.php?id=<?php echo $row['category_id'] ?>">...more</a></span></legend>
<div class="container outerpadding">
<div class="row">

<?php
    while($row_video = $video_result->fetch_assoc()) {
      $thumbnail_path ="video/".$row_video['thumbnail_path'];
?>

<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="font-size: 18px;">
      <div class="thumbnail">
        <a href="video.php?id=<?php echo $row_video['video_id']?>" >
          <img src="<?php echo $thumbnail_path?>" style="width:100%!important; height:200px">
          <div class="caption">
            <p><?php echo $row_video['caption']?></p>
          </div>
        </a>
      </div>
</div>

<?php
  }
}
?>

</div>
</div>
</div>

<?php
      }
    }
?>


<div id="about" class="container text-center"style="color: #000000; height: 400px; background-color: #C0C0C0;">
  <h1>devera.com</h1>
  <pre>devera.com is a learning website where viewers are mastering new skills and achieving heir goals.</pre> 
  <pre>This site will provide a good amount of video tutorials in various sectors of education.</pre>
</div>

<div id="contact" class="container bg-grey">
  <h3 class="text-center">Contact</h3>

  <div class="row">
    <div class="col-md-4" style="color: white;">
      <p><span class="glyphicon glyphicon-map-marker"></span>Dhaka , Bangladesh</p>
      <p><span class="glyphicon glyphicon-phone"></span>Phone: +00 0000000</p>
      <p><span class="glyphicon glyphicon-envelope"></span>Email: devera@gmail.com</p>
    </div>
    <div class="col-md-8">
      <div class="row">
        <div class="col-sm-6 form-group">
          <input class="form-control" id="email" name="email" placeholder="Enter Email" type="email" required>
        </div>
      </div>
      <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea>
      <br>
      <div class="row">
        <div class="col-md-12 form-group">
          <button class="btn pull-right" type="submit">Send</button>
        </div>
      </div>
    </div>
  </div>
</div>

 <footer class="container-fluid text-center">
  
  <p>CopyRight © 2019 Digital All Rights Reserved</p>
</footer> 

</body>
</html>
