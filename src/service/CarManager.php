<?php
namespace App\Service;

use App\Model\Car;
use PDO;

class CarManager extends AbstractManager implements ManagerInterface {

    private $pdo;

    public function __construct(PDO $pdo)
    {
        parent::__construct();
        $this->pdo = $pdo;
    }

    /**
     * @param array $array
     * @return Car
     */
    public function arrayToObject(array $array)
    {
        $car = new Car;
        $car->setId($array['id']);
        $car->setBrand($array['brand']);
        $car->setModel($array['model']);

        return $car;
    }

    /**
     * @return Car[]
     */
    public function findAll()
    {
        $query = "SELECT * FROM car";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        $cars = [];

        foreach($data as $d) {
            $cars[] = $this->arrayToObject($d);
        }

        return $cars;
    }

    /**
     * @param int $id
     * @return Car
     */
    public function findOneById(int $id)
    {
        $query = "SELECT * FROM car WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->execute(['id' => $id]);

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        $car = $this->arrayToObject($data);

        return $car;
    }

    /**
     * @param string $field
     * @param string $value
     * @return Car[]
     */
    public function findByField(string $field, string $value)
    {
    }

    /**
     * @param array $data
     */
    public function create(array $data) {
        $query = "INSERT INTO car(brand, model) VALUES(:brand, :model)";

        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'brand' => $data['brand'],
            'model' => $data['model']
        ]);
    }

    /**
     * @param array $data
     */
    public function update(int $id, array $data)
    {
        $query = "UPDATE car SET brand = :brand, model = :model WHERE id = :id";

        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id,
            'brand' => $data['brand'],
            'model'  => $data['model']
        ]);

    }

    public function delete(int $id) {
        $query = "DELETE FROM car WHERE id = :id";

        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);
    }
}