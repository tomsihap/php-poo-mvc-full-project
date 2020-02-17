<?php

namespace App\Controller;

class CarsController extends AbstractController {

    /**
     * Afficher la liste des cars
     * Route: GET /cars
     */
    public function index() {

        // 1. Récupérer les cars

        $cars = $this->container->getCarManager()->findAll();

        // 2. Afficher les cars
        echo $this->container->getTwig()->render('cars/index.html.twig', [
            'cars' => $cars
        ]);
    }

    /**
     * Afficher la page de 1 car
     * Route: GET /cars/:id
     */
    public function show(int $id) {
        // 1. Récupérer le car par son id
        $car = $this->container->getCarManager()->findOneById($id);

        //2. Afficher le car
        echo $this->container->getTwig()->render('cars/show.html.twig', [
            'car' => $car
        ]);
    }

    /**
     * Affichage du formulaire de création
     * GET /cars/new
     */
    public function new() {
        echo $this->container->getTwig()->render('cars/form.html.twig');
    }

    /**
     * Traitement du formulaire de création puis redirection vers l'index des cars
     * POST /cars/new
     */
    public function create() {
        $this->container->getCarManager()->create($_POST);
        $this->index();
    }


    /**
     * Affichage du formulaire d'édition
     * GET /cars/new
     */
    public function edit(int $id)
    {

        $car = $this->container->getCarManager()->findOneById($id);

        echo $this->container->getTwig()->render('cars/form.html.twig', ['car' => $car]);
    }

    /**
     * Traitement du formulaire d'édition puis redirection vers l'index des cars
     * POST /cars/new
     */
    public function update(int $id)
    {
        $this->container->getCarManager()->update($id, $_POST);
        $this->show($id);
    }

    /**
     * Suppression d'un car
     * GET /cars/:id/delete
     */
    public function delete(int $id) {
        
        $this->container->getCarManager()->delete($id);
        $this->index();
    }
}