<?php

require 'Router.php';

//phpinfo();

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('market', 'StallController');
Router::get('favourites', 'DefaultController');
Router::get('my_products', 'ProductController');
Router::get('contact', 'DefaultController');

Router::post('login', 'SecurityController');
Router::post('register', 'SecurityController');
Router::post('addProduct', 'ProductController');
Router::post('search', 'StallController');



Router::run($path);