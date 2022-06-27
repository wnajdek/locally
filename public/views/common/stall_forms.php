<?php if($buttonsEnabled) : ?>
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

            <button type="button">Add product</button>
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
            <button type="button">Update product</button>
        </form>
    </div>

    <div id="deleteConfirmForm" class="popup">
        <div class="close-btn">&times;</div>
        <h1 class="add-product-text">Delete Product</h1>
        <p>Are you sure you want to delete this product?</p>
        <form action="/deleteProduct" method="POST" enctype="multipart/form-data">
            <input name="id" type="number" class="hidden-input">

            <button type="button">Delete</button>
            <button id="btn-cancel" type="button">Cancel</button>

        </form>
    </div>

    <div id="changeImage" class="popup">
        <div class="close-btn">&times;</div>
        <h1 class="add-product-text">Change image</h1>
        <form action="/changeImage" method="POST" enctype="multipart/form-data">
            <?php
            if(isset($messages)){
                foreach($messages as $message) {
                    echo $message;
                }
            }
            ?>
            <input name="image" type="file" required placeholder="Image">
            <input name="id" type="number" class="hidden-input">
            <button type="button">Change image</button>
        </form>
    </div>

    <div id="changeText" class="popup">
        <div class="close-btn">&times;</div>
        <h1 class="add-product-text">Change Stall name and description</h1>
        <form action="/changeText" method="POST" enctype="multipart/form-data">
            <?php
            if(isset($messages)){
                foreach($messages as $message) {
                    echo $message;
                }
            }
            ?>
            <input name="name" type="text" placeholder="Stall name">
            <textarea name="description" placeholder="Stall description" rows="5"></textarea>
            <button type="button">Change</button>
        </form>
    </div>

    <div id="changeCategories" class="popup">
        <div class="close-btn">&times;</div>
        <h1 class="add-product-text">Change categories</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <?php
            if(isset($messages)){
                foreach($messages as $message) {
                    echo $message;
                }
            }
            ?>
            <?php foreach ($categories as $category): ?>
                <label><input type="checkbox" name="categories[]" value="<?= $category['id']?>"><?= $category['type']?></label>
            <?php endforeach; ?>
            <button type="button">Save</button>
        </form>
    </div>
<?php endif;?>
