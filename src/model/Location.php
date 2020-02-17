<?php

namespace App\Model;

class Location {

    private $id;
    private $userId;
    private $carId;
    private $user;
    private $car;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function setUserId(int $userId) {
        $this->userId = $userId;
    }

    public function getCarId() {
        return $this->carId;
    }

    public function setCarId(int $carId) {
        $this->carId = $carId;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getCar()
    {
        return $this->car;
    }

    public function setCar(Car $car)
    {
        $this->car = $car;
    }

}