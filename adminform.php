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

$target_dir = "video/";
$target_file = $target_dir . basename($_FILES["video_path"]["name"]);
$video_path = basename($_FILES["video_path"]["name"]);
$videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if($videoFileType != "mp4") {
    echo "Sorry, only MP4 is  allowed for video.";
}else {
    if (move_uploaded_file($_FILES["video_path"]["tmp_name"], $target_file)) {
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$target_dir = "video/";
$target_file = $target_dir . basename($_FILES["thumbnail_path"]["name"]);
$thumbnail_path = basename($_FILES["thumbnail_path"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed for Thumbnail.";
}else {
    if (move_uploaded_file($_FILES["thumbnail_path"]["tmp_name"], $target_file)) {
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$category_id = $_POST['category_id'];
$caption = $_POST['caption'];
$duration = $_POST['duration'];
$description = $_POST['description'];

$upload_video ="INSERT INTO `video`(`video_path`, `video_ext`, `thumbnail_path`, `category_id`, `caption`, `description`, `duration`) VALUES ('$video_path','$videoFileType','$thumbnail_path','$category_id','$caption','$description',$duration)";

  if ($conn->query($upload_video) === TRUE) {
    $msg="successfully Uploaded";
  }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>DevEra | Upload Video</title>
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
    <div class="panel-heading"><center><strong>Upload Video</strong></center></div>
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
           <form action="adminform.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="video_path">Video Upload:</label>
                <input type="file" class="form-control" id="video_path" name="video_path" required>
              </div>
              <div class="form-group">
                <label for="thumbnail_path">Thumbnail Upload:</label>
                <input type="file" class="form-control" id="thumbnail_path" name="thumbnail_path" required>
              </div>
              <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" id="category_id" name="category_id" required>
                  <?php
                      $show_category ="select * from video_category";
                      $result = $conn->query($show_category);
                      if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                  ?>
                  <option value="<?php echo $row['category_id'] ?>"><?php echo $row['category_name'] ?></option>
                  <?php
                      }
                    }
                  ?>
                </select>
                <p class="help-block"><a href="category.php">Add Category</a></p>
              </div> 
              <div class="form-group">
                <label for="caption">Caption:</label>
                <input type="text" class="form-control" id="caption" name="caption" required>
              </div>
              <div class="form-group">
                <label for="duration">Duration:</label>
                <input type="number" class="form-control" id="duration" name="duration" required>
              </div>
               <div class="form-group">
                  <label for="description">Description:</label>
                  <textarea class="form-control" rows="5" id="description" name="description" required></textarea>
                </div> 
              <input type="submit" name="submit" class="btn btn-primary btn-block" value="Upload">
            </form> 
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3"></div>
      </div>
    </div>
  </div>
</div>

	</body>
</html>
