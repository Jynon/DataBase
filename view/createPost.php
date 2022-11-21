<?php 

session_start();

if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== TRUE) {
    header("location: indexx.php");
    exit;
}

require_once "../db.php";
require_once "../models/Post.php";

$image = "";
$image_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        

        $tempname = $_FILES["image"]["tmp_name"];
        if (empty($tempname)) {
            $image_err  = "Oooops!Wrong!";
        }
    
        $filepath = tempnam("../images", "");
        rename($filepath, $filepath .= '.png');
        $originalFileName = $_FILES["image"]["name"];
        unlink($filepath);

        $pathExploded = explode('\\',$filepath);
        $filename = $pathExploded[count($pathExploded)-1];

        if (!move_uploaded_file($tempname, $filepath)) {
            header("location:indexx.php?user-id=".$_SESSION["id"]);
        }

        if (empty($image_err)) {
            $sql = "INSERT INTO posts (user_id, image) VALUES (?, ?)";
            $stmt = $dbConnection->stmt_init();
    
            if ($stmt->prepare($sql)) {
                $stmt->bind_param("is", $param_userId, $param_imageName);
                $param_imageName = $filename;
                $param_userId = $_SESSION["id"];
            }
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $image);
                    if ($stmt->fetch())
                        header("location: indexx.php?user-id=".$param_userId);
                    } else {
                        echo "Something went wrong!";
                }
        }
        $stmt->close();
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="stylesheet" href="..\style\style.css">
</head>
<body>
    <div class="header">
        <div class="nav-bar">
            <ul class="main-nav">
                <li><a href="indexx.php" class="btn btn_primary">Home</a></li>
            </ul>   
        </div>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="upload-container" enctype="multipart/form-data">
        <div class="create" id="imgBox">
            <input type="file" accept="image/*" name="image" id="file" style="display: none" onchange="loadFile(event)">
            <label for="file" class="post">Upload Image<img src="../assets\pic\upload-button.jpg" class="upload-icon"></label>
        </div>
        <button class="sub_position">Submit</button>
    </form>


<script>
    var imgBox = document.getElementById("imgBox");
    var loadFile = function(event) {
            imgBox.style.backgroundImage = "url(" +URL.createObjectURL(event.target.files[0]) + ")";
    }
</script>



</body>
</html>