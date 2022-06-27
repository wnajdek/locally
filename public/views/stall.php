<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/common.css">
    <link rel="stylesheet" type="text/css" href="/public/css/my_products.css">
    <title>My Products</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;700&family=Montserrat:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Metro UI -->
    <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/bcb9ab98f6.js" crossorigin="anonymous"></script>

    <script src="/public/js/add_stall_categories.js" type="text/javascript" defer></script>
    <script src="/public/js/add_update_delete_product.js" type="text/javascript" defer></script>
    <script src="/public/js/stall.js" type="text/javascript" defer></script>
</head>
<body>
    <div class="main-container">
        <?php include('common/navigation.php') ?>
            
        <main class="main">
            <header class="top-container" style="background-image: url('/public/uploads/stalls/<?= $stall->getImage() == 'default.jpg' ? 'default.jpg' : ((string) $stall->getId()) . '/' . $stall->getImage()?>')">
                <?php if($buttonsEnabled) : ?>
                    <p class="stall-visibility-text"><?= $status ? 'Public Stall' : 'Private Stall' ?></p>
                    <input type="checkbox" id="switch" <?= $status ? 'checked' : '' ?>/><label for="switch">Toggle</label>
<!--                <button onclick="location.href='/changeVisibility'"></button>-->
                    <button id="btn-change-image"><span class="mif-file-image mif-3x nav-icon"></span></button>
                <?php endif;?>
            </header>

            <?php include('common/stall_forms.php') ?>

            <div class="content-container">
                <div class="description-container">
                    <h2><?= $stall->getName()?></h2>
                    <p class="description"><?= $stall->getDescription()?></p>
                    <?php if($buttonsEnabled) :?>
                        <button id="btn-change-text">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    <?php endif;?>
                    <div class="categories-container">
                        <?php if($buttonsEnabled) :?>
                            <button id="btn-change-categories">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        <?php endif;?>
                        <div class="categories">
                            <?php foreach ($stallCategories as $category): ?>
                                <div class="category<?= $category['id'] ?>">
                                    <div class="category-name"><?= $category['type'] ?></div>
                                    <div class="hidden"><?= $category['id'] ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <section class="my-offer-container">
                    <?php foreach ($products as $product): ?>
                    <div id="<?= $product->getId()?>" class="product">
                        <img src="/public/uploads/products/<?= $stallId?>/<?= $product->getImage()?>" alt="">

                        <div class="product-content">
                            <h3><?= $product->getName()?></h3>
                            <p class="desc"><?= $product->getDescription()?></p>

                            <p class="price">Price: $<?= $product->getPrice()?></p>
                        </div>

                        <?php if($buttonsEnabled) : ?>
                            <button class="delete-product"><i class="fa-solid fa-trash"></i></button>
                            <button class="update-product"><i class="fa-solid fa-pencil"></i></button>
                        <?php endif;?>
                    </div>
                    <?php endforeach; ?>
                </section>

                <aside class="owner-info-container">
                    <div class="owner-info">
                        <div class="owner-photo">
                            <img src="/public/uploads/users/<?= $user->getEmail()?>/<?= $user->getImage()?>" alt="Owner photo">
                        </div>
                        <h2><?= $user->getFirstName() . ' ' . $user->getLastName() ?></h2>
                        <p><strong>Email:</strong> <?= $user->getEmail()?></p>
                        <p><strong>Phone:</strong> <?= $user->getPhoneNumber()?></p>
                        <p><strong>Address:</strong> <?= $user->getMainAddress()?></p>
                    </div>
                </aside>
            </div>
        </main>
    </div>

    <script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<!--    <script src="/public/js/my_products.js"></script>-->
</body>
    <template id="product-template">
        <div id="product" class="product">
            <img src="" alt="">

            <div class="product-content">
                <h3></h3>
                <p class="desc"></p>

                <p id="price" class="price"></p>
            </div>

        </div>
    </template>

    <template id="product-buttons-template">
        <button class="delete-product"><i class="fa-solid fa-trash"></i></button>
        <button class="update-product"><i class="fa-solid fa-pencil"></i></button>
    </template>
</html>