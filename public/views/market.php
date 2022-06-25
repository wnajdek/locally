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

    <script src="public/js/searchBox.js" type="text/javascript" defer></script>
    <script src="public/js/stats.js" type="text/javascript" defer></script>
    <script src="public/js/market.js" type="text/javascript" defer></script>
</head>
<body>
    <div class="main-container">
        <nav class="navigation">
            <a id='link-logo' href="/market">
                <h1 class="logo">Locally</h1>
                <p class="slogan">Because the good stuff is local</p>
            </a>
    
            <ul>
                <li><a href="/market" class="active-page"><span class="mif-shop nav-icon"></span>Market</a></li>
                <li><a href="/my_products"><span class="mif-home nav-icon"></span>My products</a></li>
                <li><a href="/favourites"><span class="mif-heart nav-icon"></span>Favourites</a></li>
                <li><a href="/logout"><span class="mif-keyboard-return nav-icon"></span>Log out</a></li>
                <li><a href="/contact"><span class="mif-mail nav-icon"></span>Contact</a></li>
            </ul>
        </nav>
            
        <main class="main">
            <header>
                <div class="search-bar">

                    <!-- <label for="search-by">Search by</label>
                    <select name="search-by" id="search-by">
                        <option value="farm name">farm name</option>
                        <option value="product">product</option>
                    </select> -->
                    <div class="select-box">
                        <div class="select-box__current" tabindex="1">
                            <img class="select-box__icon" src="public/image/chevron-down-circle-outline.svg" alt="Arrow Icon"
                                aria-hidden="true"/>
                            <div class="select-box__value">
                                <input class="select-box__input" type="radio" id="0" value="stall name" name="option" checked="checked" />
                                <p class="select-box__input-text">stall name</p>
                            </div>
                            <div class="select-box__value">
                                <input class="select-box__input" type="radio" id="1" value="product" name="option" />
                                <p class="select-box__input-text">product</p>
                            </div>
                            <div class="select-box__value">
                                <input class="select-box__input" type="radio" id="2" value="category" name="option" />
                                <p class="select-box__input-text">category</p>
                            </div>
                        </div>
                        <ul class="select-box__list">
                            <li>
                                <label class="select-box__option" for="0" aria-hidden="aria-hidden">stall name</label>
                            </li>
                            <li>
                                <label class="select-box__option" for="1" aria-hidden="aria-hidden">product</label>
                            </li>
                            <li>
                                <label class="select-box__option" for="2" aria-hidden="aria-hidden">category</label>
                            </li>
                        </ul>
                    </div>

                    <input type="search" name="q" placeholder="Search">

                </div>
            </header>
            <section class="offers">
                <?php foreach ($stalls as $stall): ?>
                    <div id="<?= $stall->getId() ?>" class="tile">
                        <img src="public/uploads/stalls/<?= $stall->getImage()?>" alt="Foto of market or local products">

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
                            <div class="owner-photo"></div>
                            <h2>Tom Jones</h2>
                            <p>Email: tom.jones@gmail.com</p>
                            <p>Phone: 123 456 789</p>
                            <p>Address: Zawoja 1307</p>
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

                <div class="owner-info">
                    <div class="owner-photo"></div>
                    <h2>Tom Jones</h2>
                    <p>Email: tom.jones@gmail.com</p>
                    <p>Phone: 123 456 789</p>
                    <p>Address: Zawoja 1307</p>
                </div>
            </div>
    </template>
</html>