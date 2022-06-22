<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="public/css/my_products.css">
    <title>My Products</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;700&family=Montserrat:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Metro UI -->
    <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/bcb9ab98f6.js" crossorigin="anonymous"></script>

    <script src="/public/js/add_update_delete_product.js" type="text/javascript" defer></script>
</head>
<body>
    <div class="main-container">
        <nav class="navigation">
            <h1 class="logo">Locally</h1>
            <p class="slogan">Because the good stuff is local</p>
    
            <ul>
                <li><a href="/market"><span class="mif-shop nav-icon"></span>Market</a></li>
                <li><a href="/my_products" class="active-page"><span class="mif-home nav-icon"></span>My products</a></li>
                <li><a href="/favourites"><span class="mif-heart nav-icon"></span>Favourites</a></li>
                <li><a href="/logout"><span class="mif-keyboard-return nav-icon"></span>Log out</a></li>
                <li><a href="/contact"><span class="mif-mail nav-icon"></span>Contact</a></li>
            </ul>
        </nav>
            
        <main class="main">
            <header class="top-container">
            </header>
            <button class="add-product-button" id="show-add-product-form"><i class="fa-solid fa-circle-plus"></i><span class="add-button-text">Add product</span></button>

            <div id="addProductForm" class="popup">
                <div class="close-btn">&times;</div>
                <h1 class="add-product-text">Add Product</h1>
                <form action="/addProduct" method="POST" enctype="multipart/form-data">
                    <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                    <input name="name" type="text" placeholder="Product name">
                    <input name="image" type="file" placeholder="Image">
                    <textarea name="description" placeholder="Product description" rows="5"></textarea>
                    <input name="price" type="number" placeholder="Price">

                    <button type="submit">Add product</button>
                </form>
            </div>
            <div id="updateProductForm" class="popup">
                <div class="close-btn">&times;</div>
                <h1 class="add-product-text">Update Product</h1>
                <form action="/updateProduct" method="POST" enctype="multipart/form-data">
                    <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                    <input name="name" type="text" placeholder="Product name">
                    <img src="" alt="Current product image">
                    <input name="image" type="file" placeholder="Image">
                    <textarea name="description" placeholder="Product description" rows="5"></textarea>
                    <input name="price" type="number" placeholder="Price">
                    <input name="id" type="number" class="hidden-input">

                    <button type="submit">Update product</button>
                </form>
            </div>

            <div class="content-container">
                <section class="my-offer-container">
                    <?php foreach ($products as $product): ?>
                    <div id="<?= $product->getId()?>" class="product">
                        <img src="public/uploads/products/<?= $stallId?>/<?= $product->getImage()?>" alt="">

                        <div class="product-content">
                            <h3><?= $product->getName()?></h3>
                            <p><?= $product->getDescription()?></p>

                            <p class="price">Price: $<?= $product->getPrice()?></p>
                        </div>

                        <button class="delete-product"><i class="fa-solid fa-trash"></i></button>
                        <button class="update-product"><i class="fa-solid fa-pencil"></i></button>
                    </div>
                    <?php endforeach; ?>
                </section>
                <aside class="owner-info-container">
                    <div class="owner-info">
                        <div class="owner-photo"></div>
                        <h2>Tom Jones</h2>
                        <p><strong>Email:</strong> tom.jones@gmail.com</p>
                        <p><strong>Phone:</strong> 123 456 789</p>
                        <p><strong>Address:</strong> Zawoja 1307</p>
                    </div>
                </aside>
            </div>
        </main>
    </div>
    





    <script src="https://cdn.metroui.org.ua/v4/js/metro.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="public/js/my_products.js"></script>
</body>
</html>