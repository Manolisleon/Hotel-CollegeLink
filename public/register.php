<?php
    require __DIR__.'/../boot/boot.php';

    use Hotel\User;

    //check for existing logged in user
    if (!empty(User::getCurrentUserId())) {
        header('Location: /project/public/index.php');
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <title>Αναζήτηση καταλυμάτων</title>
    <link rel="stylesheet" href="./assets/css/register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>
    <header>
        <div class="header-hotel">
            <p class="menu-logo" style="font-weight: 500;">Hotels</p>
        </div>
        <div class="menu-right">
            <a href=""><i class="fa-sharp fa-solid fa-house"></i>Home</a>
        </div>      
    </header>
    <main>
        <section class="hero">
            <form method="post" action="actions/register.php">
                <?php if (!empty($_GET['error'])) { ?>
                <div class="alert alert-danger alert-styled-left">Register Error</div>
                <?php } ?>
                <div class="name">
                    <input id="firstname" placeholder="Name:" type="text" name="name">
                    <div class="errorN" style="color: red; font-size: 15px; text-align: left;">
                        Name must be at least 5 character <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>
                <div class="email">
                    <input id="youremail" placeholder="Email:" type="email" name="email">
                    <div class="errorE" style="color: red; font-size: 15px; text-align: left;">
                        You must be a valid email address <i class="fa-solid fa-triangle-exclamation"></i>
                    </div> 
                </div>
                <div class="repeat-email">
                    <input id="email-repeat" placeholder="Email repeat:" type="email" >
                    <div class="errorER" style="color: red; font-size: 15px; text-align: left;">
                        Email doesn't match <i class="fa-solid fa-triangle-exclamation"></i>
                    </div> 
                </div>
                <div class="password">
                    <input id="yourpassword" placeholder="password" type="password" name="password">
                    <div class="errorP" style="color: red; font-size: 15px; text-align: left;">
                        Password must be at least 5 characters <i class="fa-solid fa-triangle-exclamation"></i>
                    </div> 
                </div>
                <div class="submit">
                    <input id="submit" type="submit" value="Sign Up" >
                    <section class="sign-in">
                        <p style="color: #fff; font-size: 13px;">If you have already account <a style="font-size: 13px; color: #917dee; text-decoration: underline;" href="./login.php">Sign in</a></p>
                    </section>
                </div>
            </form>
        </section>
    </main>
    <footer><p>&copy; CollegeLink Hotel</p></footer>
    <script src="./assets/js/validation.js"></script>
    <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    </body>
</html>