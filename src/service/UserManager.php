<?php
namespace App\Service;

use App\Model\User;
use PDO;

class UserManager extends AbstractManager implements ManagerInterface {

    private $pdo;

    public function __construct(PDO $pdo)
    {
        parent::__construct();
        $this->pdo = $pdo;
    }

    /**
     * @param array $array
     * @return User
     */
    public function arrayToObject(array $array)
    {
        $user = new User;
        $user->setId($array['id']);
        $user->setFirstname($array['firstname']);
        $user->setLastname($array['lastname']);

        return $user;
    }

    /**
     * @return User[]
     */
    public function findAll()
    {
        $query = "SELECT * FROM user";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        $users = [];

        foreach($data as $d) {
            $users[] = $this->arrayToObject($d);
        }

        return $users;
    }

    /**
     * @param int $id
     * @return User
     */
    public function findOneById(int $id)
    {
        $query = "SELECT * FROM user WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->execute(['id' => $id]);

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        $user = $this->arrayToObject($data);

        return $user;
    }

    /**
     * @param string $field
     * @param string $value
     * @return User[]
     */
    public function findByField(string $field, string $value)
    {
    }

    /**
     * @param array $data
     */
    public function create(array $data) {
        $query = "INSERT INTO user(firstname, lastname) VALUES(:firstname, :lastname)";

        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname']
        ]);
    }

    /**
     * @param array $data
     */
    public function update(int $id, array $data)
    {
        $query = "UPDATE user SET firstname = :firstname, lastname = :lastname WHERE id = :id";

        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id,
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname']
        ]);

    }

    public function delete(int $id) {
        $query = "DELETE FROM user WHERE id = :id";

        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);
    }
}