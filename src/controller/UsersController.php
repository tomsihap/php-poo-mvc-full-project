<?php

namespace App\Controller;

class UsersController extends AbstractController {

    /**
     * Afficher la liste des users
     * Route: GET /users
     */
    public function index() {

        // 1. Récupérer les users

        $users = $this->container->getUserManager()->findAll();

        // 2. Afficher les users
        echo $this->container->getTwig()->render('users/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * Afficher la page de 1 user
     * Route: GET /users/:id
     */
    public function show(int $id) {
        // 1. Récupérer le user par son id
        $user = $this->container->getUserManager()->findOneById($id);

        //2. Afficher le user
        echo $this->container->getTwig()->render('users/show.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * Affichage du formulaire de création
     * GET /users/new
     */
    public function new() {
        echo $this->container->getTwig()->render('users/form.html.twig');
    }

    /**
     * Traitement du formulaire de création puis redirection vers l'index des users
     * POST /users/new
     */
    public function create() {
        $this->container->getUserManager()->create($_POST);
        $this->index();
    }


    /**
     * Affichage du formulaire d'édition
     * GET /users/new
     */
    public function edit(int $id)
    {

        $user = $this->container->getUserManager()->findOneById($id);

        echo $this->container->getTwig()->render('users/form.html.twig', ['user' => $user]);
    }

    /**
     * Traitement du formulaire d'édition puis redirection vers l'index des users
     * POST /users/new
     */
    public function update(int $id)
    {
        $this->container->getUserManager()->update($id, $_POST);
        $this->show($id);
    }

    /**
     * Suppression d'un user
     * GET /users/:id/delete
     */
    public function delete(int $id) {
        
        $this->container->getUserManager()->delete($id);
        $this->index();
    }
}