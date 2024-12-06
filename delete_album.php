<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// This is the php file in deleting album
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// It will get the album id of the selected album and deletes it in the database
$album_id = $_GET['album_id'];
deleteAlbum($pdo, $album_id);
header("Location: index.php");
exit();
?>
