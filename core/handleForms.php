<?php  
require_once 'dbConfig.php';
require_once 'models.php';

// Implementation for inserting new user button
if (isset($_POST['insertNewUserBtn'])) {
    $username = trim($_POST['username']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (!empty($username) && !empty($first_name) && !empty($last_name) && !empty($password) && !empty($confirm_password)) {
        if ($password == $confirm_password) {
            $insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, password_hash($password, PASSWORD_DEFAULT));
            $_SESSION['message'] = $insertQuery['message'];

            if ($insertQuery['status'] == '200') {
                $_SESSION['message'] = $insertQuery['message'];
                $_SESSION['status'] = $insertQuery['status'];
                header("Location: ../login.php");
            } else {
                $_SESSION['message'] = $insertQuery['message'];
                $_SESSION['status'] = $insertQuery['status'];
                header("Location: ../register.php");
            }
        } else {
            $_SESSION['message'] = "Please make sure both passwords are equal";
            $_SESSION['status'] = '400';
            header("Location: ../register.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure there are no empty input fields";
        $_SESSION['status'] = '400';
        header("Location: ../register.php");
    }
}

// Implementation for login button
if (isset($_POST['loginUserBtn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $loginQuery = checkIfUserExists($pdo, $username);
        $userIDFromDB = $loginQuery['userInfoArray']['user_id'];
        $usernameFromDB = $loginQuery['userInfoArray']['username'];
        $passwordFromDB = $loginQuery['userInfoArray']['password'];

        if (password_verify($password, $passwordFromDB)) {
            $_SESSION['user_id'] = $userIDFromDB;
            $_SESSION['username'] = $usernameFromDB;
            header("Location: ../index.php");
        } else {
            $_SESSION['message'] = "Username/password invalid";
            $_SESSION['status'] = "400";
            header("Location: ../login.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure there are no empty input fields";
        $_SESSION['status'] = '400';
        header("Location: ../login.php");
    }
}

// Implementation for logout button
if (isset($_GET['logoutUserBtn'])) {
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    header("Location: ../login.php");
}

// Implementation for inserting album button
if (isset($_POST['insertPhotoBtn'])) {
    $description = $_POST['photoDescription'];
    $album_id = isset($_POST['album_id']) ? $_POST['album_id'] : null;
    $fileName = $_FILES['image']['name'];
    $tempFileName = $_FILES['image']['tmp_name'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $uniqueID = sha1(md5(rand(1,9999999)));
    $imageName = $uniqueID.".".$fileExtension;

    if (isset($_POST['photo_id'])) {
        $photo_id = $_POST['photo_id'];
    } else {
        $photo_id = "";
    }

    $saveImgToDb = insertPhoto($pdo, $imageName, $_SESSION['username'], $description, $album_id, $photo_id);

    if ($saveImgToDb) {
        $folder = "../images/".$imageName;
        if (move_uploaded_file($tempFileName, $folder)) {
            header("Location: ../index.php");
        }
    }
}

// Implementation for deleting album button
if (isset($_POST['deletePhotoBtn'])) {
    $photo_name = $_POST['photo_name'];
    $photo_id = $_POST['photo_id'];
    $deletePhoto = deletePhoto($pdo, $photo_id);

    if ($deletePhoto) {
        unlink("../images/".$photo_name);
        header("Location: ../index.php");
    }
}

// Implementation for creating album button
if (isset($_POST['createAlbumBtn'])) {
    $album_name = trim($_POST['album_name']);
    $username = $_SESSION['username'];

    if (!empty($album_name)) {
        try {
            createAlbum($pdo, $album_name, $username);
            header("Location: ../index.php");
        } catch (Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            header("Location: ../create_album.php");
        }
    } else {
        $_SESSION['message'] = "Album name cannot be empty";
        header("Location: ../create_album.php");
    }
}
?>
