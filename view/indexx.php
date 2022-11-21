<?php 

session_start();

$guest = TRUE;

require_once "../db.php";
require_once "../models/User.php";
require_once "../models/Post.php";


// $sql = "SELECT * FROM posts WHERE user_id = ?";
// $stmt = $dbConnection->stmt_init();
// if ($stmt->prepare($sql)) {
//     $stmt->bind_param("i", $param_userId);
//     $param_userId = $user->getId();
//     if ($stmt->execute()) {
//         $allUserPosts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//     } else {
//         echo "Error!";
//     } 
// } else {
//     echo "error";
// }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Little Space</title>
    <link rel="stylesheet" href="../style\style.css">
</head>
<body>
    <div class="header">
        <div class="nav-bar">
            <ul class="main-nav">
                <li><a href="indexx.php" class="btn btn_primary">Profile</a></li>
                <li><a href="createPost.php" class="btn btn_primary">Upload</a></li>
                <li><a href="../controller/Logout.php" class="btn btn_secondary">Logout</a></li>
            </ul>   
        </div>
    </div>
    <div class="profile_info">
        <h1>Welcome</h1>
        <div class="display-image">
            <?php
            $query = " select * from posts ";
            $result = mysqli_query($dbConnection, $query);
 
            while ($_FILES = mysqli_fetch_assoc($result)) {
            ?>
            <img src="../images/<?php echo $_FILES['image']; ?>">
 
            <?php
            }
            ?>
        </div>
            
    </div>
</body>
</html>
