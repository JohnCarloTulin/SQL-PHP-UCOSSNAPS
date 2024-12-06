<?php  

require_once 'dbConfig.php';

// Checks if the user exist in the database
function checkIfUserExists($pdo, $username) {
    $response = array();
    $sql = "SELECT * FROM user_accounts WHERE username = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$username])) {

        $userInfoArray = $stmt->fetch();

        if ($stmt->rowCount() > 0) {
            $response = array(
                "result"=> true,
                "status" => "200",
                "userInfoArray" => $userInfoArray
            );
        }

        else {
            $response = array(
                "result"=> false,
                "status" => "400",
                "message"=> "User doesn't exist from the database"
            );
        }
    }

    return $response;
}

// Function for inserting new user after clicking insert a new user button
function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
    $response = array();
    $checkIfUserExists = checkIfUserExists($pdo, $username); 

    if (!$checkIfUserExists['result']) {

        $sql = "INSERT INTO user_accounts (username, first_name, last_name, password) 
        VALUES (?,?,?,?)";

        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$username, $first_name, $last_name, $password])) {
            $response = array(
                "status" => "200",
                "message" => "User successfully inserted!"
            );
        }

        else {
            $response = array(
                "status" => "400",
                "message" => "An error occurred with the query!"
            );
        }
    }

    else {
        $response = array(
            "status" => "400",
            "message" => "User already exists!"
        );
    }

    return $response;
}

// Function for fetching all users in the database (array)
function getAllUsers($pdo) {
    $sql = "SELECT * FROM user_accounts";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

// Function for fetching information of user by ID in the database (array)
function getUserByID($pdo, $username) {
    $sql = "SELECT * FROM user_accounts WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$username]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

// Function for inserting photo into the database including its id and album (array)
function insertPhoto($pdo, $photo_name, $username, $description, $album_id, $photo_id="") {
    if (empty($photo_id)) {
        $sql = "INSERT INTO photos (photo_name, username, description, album_id) VALUES (?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$photo_name, $username, $description, $album_id]);
    } else {
        $sql = "UPDATE photos SET photo_name = ?, description = ?, album_id = ? WHERE photo_id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$photo_name, $description, $album_id, $photo_id]);
    }
}

// Function for fetching all the photos in the database (array)
function getAllPhotos($pdo, $username=null) {
    if (empty($username)) {
        $sql = "SELECT * FROM photos ORDER BY date_added DESC";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute();

        if ($executeQuery) {
            return $stmt->fetchAll();
        }
    }
    else {
        $sql = "SELECT * FROM photos WHERE username = ? ORDER BY date_added DESC";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$username]);

        if ($executeQuery) {
            return $stmt->fetchAll();
        }
    }
}

// Function for fetching photo by ID in the database (array)
function getPhotoByID($pdo, $photo_id) {
    $sql = "SELECT * FROM photos WHERE photo_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$photo_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

// Function for deleting photo in the database
function deletePhoto($pdo, $photo_id) {
    $sql = "DELETE FROM photos WHERE photo_id  = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$photo_id]);

    if ($executeQuery) {
        return true;
    }
}

// Function for adding comments
function insertComment($pdo, $photo_id, $username, $description) {
    $sql = "INSERT INTO comments (photo_id, username, description) VALUES(?,?,?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$photo_id, $username, $description]);

    if ($executeQuery) {
        return true;
    }
}

// Function for fetching comments by ID
function getCommentByID($pdo, $comment_id) {
    $sql = "SELECT * FROM comments WHERE comment_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$comment_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
}

// Function for editing comment
function updateComment($pdo, $description, $comment_id) {
    $sql = "UPDATE comments SET description = ? WHERE comment_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$description, $comment_id]);

    if ($executeQuery) {
        return true;
    }
}

// Function for deleting comment
function deleteComment($pdo, $comment_id) {
    $sql = "DELETE FROM comments WHERE comment_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$comment_id]);

    if ($executeQuery) {
        return true;
    }
}

// Function for retrieving all photos from a database and returns them as an array of records
function getAllPhotosJson($pdo, $username=null) {
    $sql = "SELECT * FROM photos";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}

// Function for creating album
function createAlbum($pdo, $album_name, $username) {
    $sql = "INSERT INTO albums (album_name, username) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$album_name, $username]);
}

// Function for fetching all album return them as array
function getAllAlbums($pdo) {
    $sql = "SELECT * FROM albums";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Function for fetching a certain album by ID return them as array
function getAlbumByID($pdo, $album_id) {
    $sql = "SELECT * FROM albums WHERE album_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$album_id]);
    return $stmt->fetch();
}

// Function for editing album
function updateAlbum($pdo, $album_id, $album_name) {
    $sql = "UPDATE albums SET album_name = ? WHERE album_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$album_name, $album_id]);
}

// Function for delete album
function deleteAlbum($pdo, $album_id) {
    $sql = "DELETE FROM albums WHERE album_id = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$album_id]);
}

// Function for fetching photos by album ID and return it as array
function getPhotosByAlbum($pdo, $album_id) {
    $sql = "SELECT * FROM photos WHERE album_id = ? ORDER BY date_added DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$album_id]);
    return $stmt->fetchAll();
}

?>
