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



<div class="container" style="margin-top:70px">
<div>



<?php
  $search= $_POST['search'];
  $duration=$_POST['duration'];
  if($duration=='1-5'){
    $show_video ="select * from video where caption like '%$search%' and duration BETWEEN 1 AND 5 ";
  }else if($duration=='5-10'){
    $show_video ="select * from video where caption like '%$search%' and duration BETWEEN 5 AND 10 ";
  }else{
    $show_video ="select * from video where caption like '%$search%' and duration NOT BETWEEN 1 AND 10";
  }
  $video_result = $conn->query($show_video);
    if ($video_result->num_rows > 0) {
?>

<div class="container">
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


</body>
</html>