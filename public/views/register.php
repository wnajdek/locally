<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/register.css">
    <title>Register</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;700&family=Montserrat:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Metro UI -->
    <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">

    <script src="public/js/register.js" type="text/javascript" defer></script>
</head>
<body>
<div class="main-container">
    <main class="main">
        <div class="register-container">
            <h1>Register</h1>
            <div class="messages">
                <?php
                if(isset($messages)){
                    foreach($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>
            <form action="/register" method="POST" enctype="multipart/form-data">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <input type="password" name="passwordRepeat" placeholder="Repeat your password">
                <input type="text" name="firstName" placeholder="First name">
                <input type="text" name="lastName" placeholder="Last name">
                <input type="text" name="phone" placeholder="Phone number">
                <h3>Address</h3>
                <input type="text" name="mainAddressLine" placeholder="Address line 1">
                <input type="text" name="locationDetails" placeholder="Address line 2">
                <input type="text" name="city" placeholder="City">
                <input type="text" name="postalCode" placeholder="Postal code">

                <h3>Load your picture</h3>
                <input type="file" name="image" placeholder="Image">

                <button type="submit">Sign up</button>
            </form>
        </div>
    </main>
</div>






<script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>