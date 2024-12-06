<?php require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$album_id = $_GET['album_id'];
$photos = getPhotosByAlbum($pdo, $album_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Photos</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <!-- Navigation bar -->
    <?php include 'navbar.php'; ?>
    <div class="container">

        <!-- Indicator -->
        <h1>Photos in Album</h1>

        <!-- Iterate the variable photo to show all the photos uploaded. It also shows the uploader of the photo -->
        <?php foreach ($photos as $photo) { ?>
            <div class="photoContainer" style="background-color: ghostwhite; border-style: solid; border-color: gray;width: 50%;">
                <img src="images/<?php echo $photo['photo_name']; ?>" alt="" style="width: 100%;">
                <div class="photoDescription" style="padding:25px;">
                    <a href="profile.php?username=<?php echo $photo['username']; ?>"><h2><?php echo $photo['username']; ?></h2></a>
                    <p><i><?php echo $photo['date_added']; ?></i></p>
                    <h4><?php echo $photo['description']; ?></h4>
                    <?php if ($_SESSION['username'] == $photo['username']) { ?>
                        <a href="editphoto.php?photo_id=<?php echo $photo['photo_id']; ?>" style="float: right;"> Edit </a>
                        <br><br>
                        <a href="deletephoto.php?photo_id=<?php echo $photo['photo_id']; ?>" style="float: right;"> Delete</a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>
