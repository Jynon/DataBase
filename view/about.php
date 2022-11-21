<?php 
require_once "../db.php";

$email = "";
$email_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty(trim($_POST['email']))) {
        $email_err = "Please enter email";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format";
    } else {
        $sql = "SELECT id FROM email_list WHERE email = ?";

        $stmt = $dbConnection->stmt_init();

        if ($stmt->prepare($sql)) {
            $stmt->bind_param("s", $param_email);

            $param_email = trim($_POST["email"]);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $email_err = "Email is already in use!";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                die('Something went wrong!');
            }
            $stmt->close();
        }
    }

    if (empty($email_err)) {
        $sql = "INSERT INTO email_list (email) VALUES (?)";
        $stmt = $dbConnection->stmt_init();
        if ($stmt->prepare($sql)) {
            $stmt->bind_param("s", $param_email);
            $param_email = $email;
            if ($stmt->execute()) {
                header("location: home.php");
            } else {
                    $stmt->close();
                    die("Something went wrong!");
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
    <title>About</title>
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
    <div class="banner-img">
        <div class="banner-text">
            <h4>SPACE WHERE YOU CAN LEARN ABOUT PHOTOGRAPHERS, STORIES BEHIND PICTURES AND MORE!</h4>
        </div>
    </div>
    <div class="entry_content">
        <div class="box">
            <h2>What Is Photography?</h2>
            <p>Photography is the art of capturing light with a camera, usually via a digital sensor or film, to create an image. 
                With the right camera equipment, you can even photograph wavelengths of light invisible to the human eye, including UV, infrared, and radio.
                The purpose of this article is to introduce the past and present worlds of photography. You will also find some important tips to help you take better photos along the way.

                A Brief History of Photography and the People Who Made It Succeed
                Color photography started to become popular and accessible with the release of Eastman Kodak’s “Kodachrome” film in the 1930s. Before that, almost all photos were monochromatic – 
                a handful of photographers, toeing the line between chemists and alchemists, had been using specialized techniques to capture color images for decades before. 
                You’ll find some fascinating galleries of photos from the 1800s or early 1900s captured in full color, worth exploring if you have not seen them already.
            
                These scientist-magicians, the first color photographers, are hardly alone in pushing the boundaries of one of the world’s newest art forms. The history of photography has always 
                been a history of people – artists and inventors who steered the field into the modern era.
            </p>
        </div>
        <div class="box">
            <h2>Do You Need a Fancy Camera?</h2>
            <p>Apple became the world’s first trillion dollar company in 2018 largely because of the iPhone – and what it replaced.
                Alarm clocks. Flashlights. Calculators. MP3 players. Landline phones. GPSs. Audio recorders. Cameras.
                Many people today believe that their phone is good enough for most photography, and they have no need to buy a separate camera. And you know what? They’re not wrong. 
                For most people out there, a dedicated camera is overkill.
                Phones are better than dedicated cameras for most people’s needs. They’re quicker and easier to use, not to mention their seamless integration with social media. 
                It only makes sense to get a dedicated camera if your phone isn’t good enough for the photos you want (like photographing sports or low-light environments) or if you’re specifically 
                interested in photography as a hobby.
                That advice may sound crazy coming from a photographer, but it’s true. If you have any camera at all, especially a cell phone camera, you have what you need for photography. 
                And if you have a more advanced camera, like a DSLR or mirrorless camera, what more is there to say? Your tools are up to the challenge. All that’s left is to learn how to use them.
            </p>
        </div>
        <div class="box">
            <h2>Photography training and education for teh modern photographer</h2>
            <p>In today’s competitive landscape, quality online photography training and education is priceless to your growth. Unfortunately, most publications contain a ton of fluff. 
                No real meat to their content. Not at Behind the Shutter. We are committed to the photography community and improving professional photography by providing current, insightful, 
                and in-depth educational content.
                Training topics include photography lighting techniques, photography off-camera flash tips, photography posing guides, photography business concepts and marketing strategies, Facebook for 
                photographers, boudoir and glamour photography training, high-school senior photography concepts, IPS (In-Person Sales) strategies, family photography, Lightroom tutorials, 
                Photoshop how-tos, and much, much more.
            </p>
        </div>
        <div class="box">
            <form  class="subscribe" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <p class="reg_text">Subscribe now only for discounts and news!</p>
                <label>Email</label>
                <input type="text" name="email" placeholder="Email" class="form-email"<?php echo(!empty($email_err)) ? 'is-invalid' : ''; ?>>
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                <button>Subscribe</button>
            </form>
        </div>
    </div>
</body>
</html>