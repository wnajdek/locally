<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <title>Login</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;700&family=Montserrat:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="pop-up-container">
            <div class="login-tile">
                <div class="logo-container">
                    <a id='link-logo' href="/login">
                        <h1 class="logo">Locally</h1>
                        <p class="slogan">Because the good stuff is local</p>
                    </a>
                </div>
                
                <h1 class="login-text">Login to Your Account</h1>
                <div class="messages">
                    <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <form action="login" method="POST">
                    <input name="email" type="email" placeholder="Email">
                    <input name="password" type="password" placeholder="Password">
    
                    <button type="submit">Sign In</button>
                </form>
            </div>
        
        
            <div class="sign-up-tile">
                <h1 class="text-above-sign-up-button">Are You New Here?</h1>
    
                <button onclick="location.href='/register'">Sign Up</button>
            </div>
        </div>
    </div>
</body>
</html>