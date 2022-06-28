<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/market.css">
    <title>Market</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;700&family=Montserrat:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Metro UI -->
    <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">

    <script src="/public/js/add_stall_categories.js" type="text/javascript" defer></script>
    <script src="public/js/searchBox.js" type="text/javascript" defer></script>
    <script src="public/js/stats.js" type="text/javascript" defer></script>
    <script src="public/js/market.js" type="text/javascript" defer></script>
</head>
<body>
    <div class="main-container">
        <?php include('common/navigation.php') ?>

        <main class="main">
            <?php include('common/search_bar.php') ?>

            <section class="offers">
                <?php foreach ($stalls as $stall): ?>
                    <div id="<?= $stall->getId() ?>" class="tile">
                        <img src="public/uploads/stalls/<?= $stall->getImage() != 'default.jpg' ? (string) $stall->getId() . '/' : '' ?>/<?= $stall->getImage()?>" alt="Foto of market or local products">

                        <h3><?= $stall->getName()?></h3>
                        <p><?= $stall->getDescription()?></p>

                        <div class="categories">
                            <?php foreach ($stallCategories[$stall->getId()] as $category): ?>
                                <div class="category<?= $category['id'] ?>">
                                    <div class="category-name"><?= $category['type'] ?></div>
                                    <div class="hidden"><?= $category['id'] ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button class="tile-button">See offer</button>

                        <div class="likes">
                            <button><span class="mif-heart <?= in_array($stall->getId(), $likedStalls) ? 'liked' : 'not-liked'; ?>"></span></button>
                            <span class="likes-number"><?= $stall->getLikes()?></span>
                        </div>

                        <ion-icon name="person-circle-sharp" class="owner-icon"></ion-icon>

                        <div class="owner-info">
                            <div class="owner-photo">
                                <img src="/public/uploads/users/<?= $users[$stall->getId()]->getEmail() ?>/<?= $users[$stall->getId()]->getImage() ?>" alt="">
                            </div>
                            <h2><?= $users[$stall->getId()]->getFirstName() ?> <?= $users[$stall->getId()]->getLastName() ?></h2>
                            <p class="email"><strong>Email: </strong> <?= $users[$stall->getId()]->getEmail() ?></p>
                            <p class="phone"><strong>Phone: </strong> <?= chunk_split($users[$stall->getId()]->getPhoneNumber(), 3, ' ')  ?></p>
                            <p class="address"><strong>Address: </strong> <?= $users[$stall->getId()]->getMainAddress() ?>,
                                <?= $users[$stall->getId()]->getPostalCode() ?> <?= $users[$stall->getId()]->getCity() ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </main>
        <div class="search-container">
    
        </div>
    </div>

    <script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
    <template id="stall-template">
            <div id="market1" class="tile">
                <img src="" alt="Foto of market or local products">

                <h3>name</h3>
                <p>description</p>

                <div class="categories">

                </div>

                <button class="tile-button">See offer</button>

                <div class="likes">
                    <button><span class="mif-heart"></span></button>
                    <span class="likes-number">likes</span>
                </div>

                <ion-icon name="person-circle-sharp" class="owner-icon"></ion-icon>
            </div>
    </template>
    <template id="user-info-template">
        <div class="owner-info">
            <div class="owner-photo">
                <img src="" alt="">
            </div>
            <h2>Tom Jones</h2>
            <p class="email">Email: tom.jones@gmail.com</p>
            <p class="phone">Phone: 123 456 789</p>
            <p class="address">Address: Zawoja 1307</p>
        </div>
    </template>
</html>