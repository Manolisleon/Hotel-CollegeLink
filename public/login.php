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
            <a href="index.php"><i class="fa-sharp fa-solid fa-house"></i>Home</a>
        </div>      
    </header>
    <main>
        <section class="hero">
            <form method="post" action="actions/login.php">
                <div class="email">
                    <input id="youremail" placeholder="Email:" type="email" name="email" >
                </div>
                <div class="password">
                    <input id="yourpassword" placeholder="password" type="password" name="password" > 
                </div>
                <div class="submit">
                    <input type="submit" value="Login" >
                    <section class="sign-in">
                        <p style="color: #fff; font-size: 13px;">If you have not account <a style="font-size: 13px; color: #917dee; text-decoration: underline;" href="./register.php">Sign up</a></p>
                    </section>
                </div>
            </form>
        </section>
    </main>
    <footer><p>&copy; CollegeLink Hotel</p></footer>
    <link rel="stylesheet" href="assets/css/fontawesome.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    </body>