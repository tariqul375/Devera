<?php
session_start();
if(empty($_SESSION["username"]))
{
  header('Location: login.php');
}
require 'connection.php';
$email = $_SESSION["email"];
$user_id = 0;
$search_user= "select * from userinfo where email='$email'";
$result_user = $conn->query($search_user);
if ($result_user->num_rows > 0) {
  while($row_user = $result_user->fetch_assoc()) {
    $user_id = $row_user['userinfo_id'];
  }
}
if(isset($_POST['submit']))
{
  $bookmark_id = $_POST['bookmark_id'];
  $delete_bookmark = "DELETE FROM `bookmarks` WHERE bookmark_id =$bookmark_id";
  $conn->query($delete_bookmark);
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
  <div class="panel panel-default">
    <div class="panel-body">
      <div class=" col-sm-10">
        <?php
        $show_details = "select * from userinfo where userinfo_id='$user_id'";
        $result_details = $conn->query($show_details);
        if ($result_details->num_rows > 0) {
          while($row_details = $result_details->fetch_assoc()) {
        ?>
            <p><strong>Username: </strong><?php echo $row_details['username']?></p>
            <p><strong>Email: </strong><?php echo $row_details['email']?></p>
        <?php
          }
        }
        ?>
        </div>        
        <div class=" col-sm-2">
            <div class="btn-group">
                <a class="btn dropdown-toggle btn-info" data-toggle="dropdown" href="#">
                    Action 
                    <span class="icon-cog icon-white"></span><span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="useredit.php"><span class="icon-wrench"></span> Modify</a></li>
                </ul>
            </div>
        </div>
    </div>
  </div>
</div>


<div class="container">
  <div class="panel panel-default">
    <div class="panel-body">
    <h3>Bookmark videos</h3>
      <div class="row">
        <?php
        $show_bookmarks = "select * from bookmarks where user_id='$user_id'";
        $result_bookmarks = $conn->query($show_bookmarks);
        if ($result_bookmarks->num_rows > 0) {
          while($row_bookmarks = $result_bookmarks->fetch_assoc()) {
            $video_id = $row_bookmarks['video_id'];
            $bookmark_id = $row_bookmarks['bookmark_id'];
            $sql_video="SELECT * FROM `video` where video_id =$video_id";
            $result_video = $conn->query($sql_video);
            if ($result_video->num_rows > 0) {
                while($row_video = $result_video->fetch_assoc()) {
                    $thumbnail_path ="video/".$row_video['thumbnail_path'];
                    $video_id = $row_video['video_id'];
                    $caption = $row_video['caption'];
        ?>
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
          <div class="thumbnail">
            <a href="video.php?id=<?php echo $video_id ?>">
              <img src="<?php echo $thumbnail_path ?>"  style="width:100%; height:100px">
              <div class="caption">
                <p><?php echo $caption ?></p>
              <form action="userprofile.php" method="post">
               <input type="hidden" name="bookmark_id" value="<?php echo $bookmark_id?>">
               <input type="submit" name="submit" value="remove" class="btn btn-danger btn-xs"> 
              </form>
              </div>
            </a>
          </div>
        </div>
        <?php
      }
    }
  }
}
        ?>
      </div>
    </div>
  </div>
</div>


</body>
</html>