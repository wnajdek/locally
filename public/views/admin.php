<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/contact.css">
    <title>Admin panel</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;700&family=Montserrat:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Metro UI -->
    <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">

    <script src="public/js/admin.js" type="text/javascript" defer></script>
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
            <li><a href="/user"><span class="mif-user nav-icon"></span>User</a></li>
            <?php if($_SESSION['isAdmin']) :?>
                <li><a href="/admin" class="active-page"><span class="mif-cog nav-icon"></span>Admin</a></li>
            <?php endif;?>
            <li><a href="/logout"><span class="mif-keyboard-return nav-icon"></span>Log out</a></li>
            <li><a href="/contact" class="active-page"><span class="mif-mail nav-icon"></span>Contact</a></li>
        </ul>
    </nav>

    <main class="main">
        <div class="contact-container">


            <?php foreach ($users as $user): ?>
                <?php if($user->getId() === $_SESSION['userId']) :?>
                    <h1>Currently simulated user</h1>

                <div class="user" id="<?= $user->getEmail() ?>">
                    <h3 class="user-id"><?= $user->getId() ?></h3>
                    <h3 class="user-email"><?= $user->getEmail() ?></h3>
                    <span class="user-role">Role: <strong><?= $user->getRole() ?></strong></span>
                </div>
                <?php endif;?>

            <?php endforeach; ?>
            <h1>Available users</h1>
            <div class="users-container">
                <?php foreach ($users as $user): ?>
                    <?php if($user->getId() !== $_SESSION['userId']) :?>

                    <div class="user" id="<?= $user->getEmail() ?>">
                        <h3 class="user-id"><?= $user->getId() ?></h3>
                        <h3 class="user-email"><?= $user->getEmail() ?></h3>
                        <span class="user-role">Role: <strong><?= $user->getRole() ?></strong></span>
                        <button type="button" class="pick-this-user">Pick</button>
                        <button type="button" class="delete-this-user">Delete</button>
                    </div>
                    <?php endif;?>
                <?php endforeach; ?>

            </div>
        </div>
    </main>
</div>






<script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>