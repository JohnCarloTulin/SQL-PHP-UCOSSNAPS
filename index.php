<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>

    <!-- Navigation bar -->
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1>Albums</h1>
        <a href="create_album.php">Create New Album</a>

        <!-- Iterates the database and shows all the album -->
        <?php $albums = getAllAlbums($pdo, $_SESSION['username']); ?>
        <ul>
            <?php foreach ($albums as $album) { ?>
                <li>
                    <a href="album.php?album_id=<?php echo $album['album_id']; ?>"><?php echo $album['album_name']; ?></a>
                    <a href="edit_album.php?album_id=<?php echo $album['album_id']; ?>">Edit</a>
                    <a href="delete_album.php?album_id=<?php echo $album['album_id']; ?>">Delete</a>
                </li>
            <?php } ?>
        </ul>

        <!-- Input forms for inserting photo and has the option where album to be uploaded -->
        <h1>Insert Photo</h1>
        <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
            <p>
                <label for="#">Description</label>
                <input type="text" name="photoDescription">
            </p>
            <p>
                <label for="#">Photo Upload</label>
                <input type="file" name="image">
            </p>
            <p>
                <label for="album_id">Select Album</label>
                <select name="album_id" required>
                    <?php foreach ($albums as $album) { ?>
                        <option value="<?php echo $album['album_id']; ?>"><?php echo $album['album_name']; ?></option>
                    <?php } ?>
                </select>
            </p>
            <p>
                <input type="submit" name="insertPhotoBtn" value="Insert Photo">
            </p>
        </form>
    </div>
</body>
</html>
