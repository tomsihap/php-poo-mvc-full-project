<?php
namespace App\Service;

use App\Model\Location;
use PDO;

class LocationManager extends AbstractManager implements ManagerInterface {

    private $pdo;

    public function __construct(PDO $pdo)
    {
        parent::__construct();
        $this->pdo = $pdo;
    }

    /**
     * @param array $array
     * @return Location
     */
    public function arrayToObject(array $array)
    {
        $location = new Location;
        $location->setId($array['id']);
        $location->setUserId($array['user_id']);
        $location->setCarId($array['car_id']);

        $car = $this->container->getCarManager()->findOneById($array['car_id']);
        $user = $this->container->getUserManager()->findOneById($array['user_id']);

        $location->setCar($car);
        $location->setUser($user);

        return $location;
    }

    /**
     * @return Location[]
     */
    public function findAll()
    {
        $query = "SELECT * FROM location";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        $locations = [];

        foreach($data as $d) {
            $locations[] = $this->arrayToObject($d);
        }

        return $locations;
    }

    /**
     * @param int $id
     * @return Location
     */
    public function findOneById(int $id)
    {
        $query = "SELECT * FROM location WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->execute(['id' => $id]);

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        $location = $this->arrayToObject($data);

        return $location;
    }

    /**
     * @param string $field
     * @param string $value
     * @return Location[]
     */
    public function findByField(string $field, string $value)
    {
    }

    /**
     * @param array $data
     */
    public function create(array $data) {
        $query = "INSERT INTO location(user_id, car_id) VALUES(:user_id, :car_id)";

        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'user_id' => $data['user_id'],
            'car_id' => $data['car_id']
        ]);
    }

    /**
     * @param array $data
     */
    public function update(int $id, array $data)
    {
        $query = "UPDATE location SET user_id = :user_id, car_id = :car_id WHERE id = :id";

        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id,
            'user_id' => $data['user_id'],
            'car_id'  => $data['car_id']
        ]);

    }

    public function delete(int $id) {
        $query = "DELETE FROM location WHERE id = :id";

        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);
    }
}