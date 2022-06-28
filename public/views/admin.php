<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/admin.css">
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
    <?php include('common/navigation.php') ?>

    <main class="main">
        <div class="table-container">
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