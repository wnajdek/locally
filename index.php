<?php

require 'Router.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('market', 'DefaultController');
Router::get('favourites', 'DefaultController');
Router::get('myProducts', 'DefaultController');
Router::get('contact', 'DefaultController');

Router::post('login', 'SecurityController');



Router::run($path);