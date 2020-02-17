<?php
// /src/service/ManagerInterface.php
namespace App\Service;

interface ManagerInterface {

    public function findAll();
    public function findOneById(int $id);
    public function findByField(string $field, string $value);
    public function arrayToObject(array $array);

}