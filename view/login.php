<?php 

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === TRUE) {
    header("location: indexx.php");
    exit;
}
session_start();

require_once "../db.php";

$usernameOrEmail = $password = "";
$usernameOrEmail_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["usernameOrEmail"]))) {
        $usernameOrEmail_err = "Please enter username!";
    } else {
        $usernameOrEmail = trim($_POST["usernameOrEmail"]);
    }
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter password!";
    } else {
        $password = trim($_POST["password"]);
    }
    if (empty($usernameOrEmail_err) && empty($password_err)) {
        $sql = "SELECT id, username, email, password FROM users WHERE username = ? OR email = ?";
        $stmt = $dbConnection->stmt_init();
        if ($stmt->prepare($sql)) {
            $stmt->bind_param("ss", $param_usernameOrEmail, $param_usernameOrEmail);
            $param_usernameOrEmail = $usernameOrEmail;
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $username, $email, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION = array();
                            $_SESSION["loggedin"] = TRUE;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            header("location: indexx.php");
                        } else {
                            $login_err = "Invalid username/email or password!";
                        }
                    }
                } else {
                    $login_err = "Invalid username/email or password!";
                }
                
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../style\style.css">
</head>
<body>
    <div class="header">
        <div class="nav-bar">
            <ul class="main-nav">
                <li><a href="home.php" class="btn btn_primary">Home</a></li>
                <li><a href="about.php" class="btn btn_primary">About</a></li>
                <li><a href="gallery.php" class="btn btn_primary">Gallery</a></li>
                <li><a href="login.php" class="btn btn_secondary">Login</a></li>
                <li><a href="register.php" class="btn btn_secondary">Sign Up</a></li>
            </ul>   
        </div>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="login">
            <h2>Login</h2>
            <label>Username or Email</label>
            <input type="text" name="usernameOrEmail" placeholder="Enter Username/Email" class="form-control<?php echo(!empty($usernameOrEmail_err)) ? 'is-invalid' : ''; ?>"value="<?php echo $usernameOrEmail; ?>">
            <span class="invalid-feedback"><?php echo $usernameOrEmail_err; ?></span>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter Password" class="form-control<?php echo(!empty($password_err)) ? 'is-invalid' : ''; ?>"value="<?php echo $password; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>

            <button>Log In</button>
        </div>
    </form>
</body>
</html>