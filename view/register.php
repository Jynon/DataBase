<?php 

require_once "../db.php";

$username = $email = $password = $password_confirm = "";
$username_err = $email_err = $password_err = $password_confirm_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letter, numbers and underscores!";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = $dbConnection->stmt_init();
        if ($stmt->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows() == 1) {
                    $username_err = "This username is already taken!";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Something went wrong!";
            }
        }
        $stmt->close();
    }
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter password!";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password need to be at least 6 characters long!";
    } else {
        $password = trim($_POST["password"]);
    }
    if (empty(trim($_POST["confirm_password"]))) {
        $password_confirm_err = "Please confirm your password";
    } else {
        $password_confirm = trim($_POST["confirm_password"]);
        if ($password != $password_confirm) {
            $password_confirm_err = "Password do not match!";
        }
    }
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter email";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format!";
    } else {
        $sql = "SELECT id FROM users WHERE email = ?";
        $stmt = $dbConnection->stmt_init();
        if ($stmt->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = trim($_POST["email"]);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $email_err = "You have already registered!";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($password_confirm_err)) {
        $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
        $stmt = $dbConnection->stmt_init();
        if ($stmt->prepare($sql)) {
            $stmt->bind_param("sss", $param_username, $param_email, $param_password);
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            if ($stmt->execute()) {
                header("location: login.php");
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
    <title>Sign Up</title>
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
            <h2>Sign Up</h2>
            <p class="reg_text">Please register to create an account</p>
            <label>Username</label>
            <input type="text" name="username" placeholder="Username" class="form-control<?php echo(!empty($username_err)) ? 'is-invalid' : ''; ?>"value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>


            <label>Email</label>
            <input type="text" name="email" placeholder="Email" class="form-control<?php echo(!empty($email_err)) ? 'is-invalid' : ''; ?>"value="<?php echo $email; ?>">
            <span class="invalid-feedback"><?php echo $email_err; ?></span>

            <label>Password</label>
            <input type="password" name="password" placeholder="Password" class="form-control<?php echo(!empty($password_err)) ? 'is-invalid' : ''; ?>"value="<?php echo $password; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>


            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control<?php echo(!empty($password_confirm_err)) ? 'is-invalid' : ''; ?>"value="<?php echo $password_confirm; ?>">
            <span class="invalid-feedback"><?php echo $password_confirm_err; ?></span>


            <button class="sign_up">Sign Up</button>
        </div>
    </form>
</body>
</html>