<?php

namespace App\Controller;

class LocationsController extends AbstractController {

    /**
     * Afficher la liste des locations
     * Route: GET /locations
     */
    public function index() {

        // 1. Récupérer les locations
        $locations = $this->container->getLocationManager()->findAll();

        // 2. Afficher les locations
        echo $this->container->getTwig()->render('locations/index.html.twig', [
            'locations' => $locations
        ]);
    }

    /**
     * Afficher la page de 1 location
     * Route: GET /locations/:id
     */
    public function show(int $id) {
        // 1. Récupérer le location par son id
        $location = $this->container->getLocationManager()->findOneById($id);

        //2. Afficher le location
        echo $this->container->getTwig()->render('locations/show.html.twig', [
            'location' => $location
        ]);
    }

    /**
     * Affichage du formulaire de création
     * GET /locations/new
     */
    public function new() {

        $users = $this->container->getUserManager()->findAll();
        $cars = $this->container->getCarManager()->findAll();
        

        echo $this->container->getTwig()->render('locations/form.html.twig', [
            'cars' => $cars,
            'users' => $users
        ]);
    }

    /**
     * Traitement du formulaire de création puis redirection vers l'index des locations
     * POST /locations/new
     */
    public function create() {
        $this->container->getLocationManager()->create($_POST);
        $this->index();
    }


    /**
     * Affichage du formulaire d'édition
     * GET /locations/new
     */
    public function edit(int $id)
    {

        $location = $this->container->getLocationManager()->findOneById($id);
        $users = $this->container->getUserManager()->findAll();
        $cars = $this->container->getCarManager()->findAll();

    
        echo $this->container->getTwig()->render('locations/form.html.twig', [
            'location' => $location,
            'cars'  => $cars,
            'users' => $users
        ]);
    }

    /**
     * Traitement du formulaire d'édition puis redirection vers l'index des locations
     * POST /locations/new
     */
    public function update(int $id)
    {
        $this->container->getLocationManager()->update($id, $_POST);
        $this->show($id);
    }

    /**
     * Suppression d'un location
     * GET /locations/:id/delete
     */
    public function delete(int $id) {
        
        $this->container->getLocationManager()->delete($id);
        $this->index();
    }
}