<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/user.css">
    <title>User Data</title>

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
    <nav class="navigation">
        <a id='link-logo' href="/market">
            <h1 class="logo">Locally</h1>
            <p class="slogan">Because the good stuff is local</p>
        </a>

        <ul>
            <li><a href="/market"><span class="mif-shop nav-icon"></span>Market</a></li>
            <li><a href="/my_products"><span class="mif-home nav-icon"></span>My products</a></li>
            <li><a href="/favourites"><span class="mif-heart nav-icon"></span>Favourites</a></li>
            <li><a href="/user" class="active-page"><span class="mif-user nav-icon"></span>User</a></li>
            <li><a href="/logout"><span class="mif-keyboard-return nav-icon"></span>Log out</a></li>
            <li><a href="/contact"><span class="mif-mail nav-icon"></span>Contact</a></li>
        </ul>
    </nav>
    <main class="main">
        <div class="user-container">
            <h1>Your personal data</h1>
            <div class="messages">
                <?php
                if(isset($messages)){
                    foreach($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>
            <form action="/updateUserData" method="POST" enctype="multipart/form-data">
                <input type="email" name="email" placeholder="Email" readonly="readonly" value="<?= $user->getEmail()?>" disabled>
                <input type="text" name="firstName" placeholder="First name" value="<?= $user->getFirstName()?>" required>
                <input type="text" name="lastName" placeholder="Last name" value="<?= $user->getLastName()?>" required>
                <input type="text" name="phoneNumber" placeholder="Phone number" value="<?= $user->getPhoneNumber()?>" required>
                <h3>Address</h3>
                <input type="text" name="mainAddress" placeholder="Address line 1" value="<?= $user->getMainAddress()?>" required>
                <input type="text" name="locationDetails" placeholder="Address line 2" value="<?= $user->getLocationDetails()?>">
                <input type="text" name="city" placeholder="City" value="<?= $user->getCity()?>" required>
                <input type="text" name="postalCode" placeholder="Postal code" value="<?= $user->getPostalCode()?>" required>

                <h3>Load your picture</h3>
                <h4>Current picture</h4>
                <img src="/public/uploads/users/<?= $user->getEmail()?>/<?= $user->getImage()?>" alt="Current image">
                <h4>New picture</h4>
                <input type="file" name="image" placeholder="Image">

                <button type="submit">Save</button>
            </form>

            <h3>Change password</h3>
            <form action="/changePassword" method="POST" enctype="multipart/form-data">
                <input type="password" name="passwordOld" placeholder="Current password" required>
                <input type="password" name="password" placeholder="New password" required>
                <input type="password" name="passwordRepeat" placeholder="Repeat your new password" required>

                <button type="submit">Update password</button>
            </form>
        </div>
    </main>
</div>






<script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>