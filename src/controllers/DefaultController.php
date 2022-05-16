<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        $this -> render('login');
    }

    public function market() {
        $this -> render('market');
    }

    public function favourites() {
        $this -> render('favourites');
    }

    public function myProducts() {
        $this -> render('my_products');
    }

    public function contact() {
        $this -> render('contact');
    }

//    public function login() {
//        $this -> render('login');
//    }
}