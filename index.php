<?php

require 'Router.php';

//phpinfo();

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('market', 'StallController');
Router::get('favourites', 'DefaultController');
Router::get('my_products', 'StallController');
Router::get('contact', 'MailController');
Router::get('changeVisibility', 'StallController');

Router::post('login', 'SecurityController');
Router::post('logout', 'SecurityController');
Router::post('register', 'SecurityController');
Router::post('addProduct', 'ProductController');
Router::post('updateProduct', 'ProductController');
Router::post('deleteProduct', 'ProductController');
Router::post('search', 'StallController');
Router::post('like', 'StallController');
Router::post('changeImage', 'StallController');
Router::post('changeText', 'StallController');
Router::post('updateStallCategories', 'StallController');
Router::get('mail', 'MailController');




Router::run($path);