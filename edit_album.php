<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Exception handling for logging in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$album_id = $_GET['album_id'];
$album = getAlbumByID($pdo, $album_id);

// Exception handling for updating album
if (isset($_POST['updateAlbumBtn'])) {
    $album_name = trim($_POST['album_name']);
    if (!empty($album_name)) {
        updateAlbum($pdo, $album_id, $album_name);
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['message'] = "Album name cannot be empty";
        header("Location: edit_album.php?album_id=$album_id");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <!-- Navigation bar -->
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Edit Album</h1>

        <!-- Input form for editing album name -->
        <form action="edit_album.php?album_id=<?php echo $album_id; ?>" method="POST">
            <p>
                <label for="album_name">Album Name</label>
                <input type="text" name="album_name" value="<?php echo $album['album_name']; ?>" required>
            </p>
            <p>
                <input type="submit" name="updateAlbumBtn" value="Update Album">
            </p>
        </form>
    </div>
</body>
</html>
