<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// When the user is not registered or input fields are empty, it will go back to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// This is the implementation of create album button when clicked
if (isset($_POST['createAlbumBtn'])) {
    $album_name = trim($_POST['album_name']);
    $username = $_SESSION['username'];

    // Debugging statement for verification of username
    error_log("Creating album for username: " . $username);

    if (!empty($album_name)) {

        // Exception handling for creating album, if it fails, it will logs error message and it will go back to the create album page
        try {
            createAlbum($pdo, $album_name, $username);
            header("Location: index.php");
            exit();
        } catch (Exception $e) {
            // Debugging statement for the exception
            error_log("Exception: " . $e->getMessage());
            $_SESSION['message'] = $e->getMessage();
            header("Location: create_album.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Album name cannot be empty";
        header("Location: create_album.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Album</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>

    <!-- Navigation bar -->
    <?php include 'navbar.php'; ?>
    <div class="container">
        <!-- Prompt to user -->
        <h1>Create Album</h1>

        <!-- Input forms for creating album -->
        <form action="create_album.php" method="POST">
            <p>
                <label for="album_name">Album Name</label>
                <input type="text" name="album_name" required>
            </p>
            <p>
                <input type="submit" name="createAlbumBtn" value="Create Album">
            </p>
        </form>
    </div>
</body>
</html>
