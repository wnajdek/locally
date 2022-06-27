<?php

require 'Router.php';

//phpinfo();

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'SecurityController');
Router::get('user', 'SecurityController');
Router::get('market', 'StallController');
Router::get('favourites', 'StallController');
Router::get('my_products', 'StallController');
Router::get('contact', 'MailController');
Router::get('changeVisibility', 'StallController');
Router::get('admin', 'SecurityController');
Router::get('mail', 'MailController');
Router::get('simulateUser', 'SecurityController');
Router::get('deleteUser', 'SecurityController');

Router::post('login', 'SecurityController');
Router::post('logout', 'SecurityController');
Router::post('register', 'SecurityController');
Router::post('updateUserData', 'SecurityController');
Router::post('changePassword', 'SecurityController');
Router::post('addProduct', 'ProductController');
Router::post('updateProduct', 'ProductController');
Router::post('deleteProduct', 'ProductController');
Router::post('search', 'StallController');
Router::post('like', 'StallController');
Router::post('changeImage', 'StallController');
Router::post('changeText', 'StallController');
Router::post('updateStallCategories', 'StallController');





Router::run($path);