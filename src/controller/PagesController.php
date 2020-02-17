<?php

namespace App\Controller;

class PagesController extends AbstractController {

    /**
     * Route: page d'accueil ('/')
     */
    public function index() {
        echo $this->container->getTwig()->render('pages/index.html.twig');
    }

}