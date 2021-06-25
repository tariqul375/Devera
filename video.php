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
if(isset($_POST['playlist']))
{
  $video_id = $_POST['video_id'];
  $insert_bookmark ="INSERT INTO `bookmarks`(`user_id`, `video_id`) VALUES ($user_id,$video_id)";
  $conn->query($insert_bookmark);
}

if(isset($_POST['submit_comment']))
{
  $video_id = $_POST['video_id'];
  $comment = $_POST['comment'];
  $insert_comment ="INSERT INTO `comment`(`user_id`, `video_id`, `comment`) VALUES ($user_id,$video_id,'$comment')";
  $conn->query($insert_comment);
}
if(isset($_POST['submit']))
{
  $comment_id =$_POST['commentid'];
  $comment_delete = "delete from comment where comment_id=$comment_id";
  if ($conn->query($comment_delete) === TRUE) {
    $msg="successfully deleted";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Devera</title>
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
      <a class="navbar-brand" href="home.php">Devera</a>
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
<div class="row">
<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

<?php
$id=$_GET['id'];
$category_id = 0;
$sql="SELECT * FROM `video` where video_id =$id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $video_path="video/".$row["video_path"];
        $video_ext= $row["video_ext"];
        $video_id = $row['video_id'];
        $caption = $row['caption'];
        $description = $row['description'];
        $category_id = $row['category_id'];
?>
<div class="col-md-12">
<video  controls autoplay style="width:100%" controlsList="nodownload">
  <source src="<?php echo $video_path?>" type="video/<?php echo $video_ext?>">
</video>
<br>
<h3><strong><?php echo $caption?></strong></h3>

<form method="post" action="video.php?id=<?php echo $id?>">
  <input type="hidden" name="video_id" value="<?php echo $video_id ?>">
 <input type="submit" name="playlist" class="btn btn-primary btn-sm pull-right" value="Add to playlist"> 
</form>


<br><br>
<legend><h3>Desciption</h3></legend>
<p><?php echo $description?></p>
<br>
<div class="well">
<form action="video.php?id=<?php echo $id?>" method="post">
<div class="form-group">
  <label for="comment">Comment:</label>
  <input type="hidden" name="video_id" value="<?php echo $video_id ?>">
  <textarea class="form-control" rows="5" id="comment" name="comment" placeholder="Write Your Comment"></textarea>
</div>
  <input type="submit" name="submit_comment" class="btn btn-primary pull-right" value="submit">
</form>
<br>
<h3><legend>All Comments</legend></h3>
<?php
$id=$_GET['id'];
$comment_sql="SELECT userinfo.username, comment.comment ,comment.comment_id FROM userinfo
INNER JOIN comment ON userinfo.userinfo_id = comment.user_id where comment.video_id = $id";
$result_comment = $conn->query($comment_sql);
if ($result_comment->num_rows > 0) {
    while($row_comment= $result_comment->fetch_assoc()) {
?>
<div class="media">
  <div class="media-left">
    <h4 class="media-heading" style="color:blue"><?php echo $row_comment['username']?></h4>
  </div>
  <div class="media-body">
    <p><?php echo $row_comment['comment']?></p>
  </div>
  <div class="media-right">
    <?php 
      if($_SESSION["username"]=='admin' || $_SESSION["username"]==$row_comment['username']){
    ?>
    <form action="" method="post">
      <input type="hidden" name="commentid" value="<?php echo $row_comment['comment_id'] ?>">
      <input type="submit" name="submit" class="btn btn-danger btn-xs" value="delete">
    </form>
    <?php
      }
    ?>
  </div>
</div>
<?php
}
}
?>
</div>

</div>

<?php
}
}
?>
</div>

<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
<?php
$suggested_video="SELECT * FROM `video` where category_id =$category_id";
$result_suggested_video = $conn->query($suggested_video);
if ($result_suggested_video->num_rows > 0) {
    while($row_result = $result_suggested_video->fetch_assoc()) {
        $video_path="video/".$row_result["video_path"];
        $thumbnail_path ="video/".$row_result['thumbnail_path'];
        $video_ext= $row_result["video_ext"];
        $video_id = $row_result['video_id'];
        $caption = $row_result['caption'];
        $description = $row_result['description'];
?>
<div class="row">
  <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
      <div class="thumbnail">
        <a href="video.php?id=<?php echo $video_id?>" >
          <img src="<?php echo $thumbnail_path?>" style="width:100%!important; height:100px">
        </a>
      </div>
  </div>
  <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
    <span><strong><?php echo $caption?></strong></span>
  </div>
</div>
<br>
<?php
}
}
?>
</div>

</div>
</div>

<script type="text/javascript">
function playVideo(x){
  window.location = 'video.php?id='+x;
}
</script>

</body>
</html>