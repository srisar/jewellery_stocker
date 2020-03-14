<?php


namespace Jman\Models;


use Jman\Core\Database;
use PDO;

class UserModel
{

    /**
     * Find a user with given id
     * @param int $id
     * @return User
     */
    public static function find(int $id): ?User
    {

        $db = Database::get_instance();
        $statement = $db->prepare("SELECT * FROM users WHERE id=?");
        $statement->execute([$id]);

        $result = $statement->fetchObject(User::class);

        if (!empty($result))
            return $result;
        else
            return null;

    }

    /**
     * Find all users in db
     * @return User[]
     */
    public static function all(): ?array
    {
        $db = Database::get_instance();
        $statement = $db->prepare("SELECT * FROM users");
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_CLASS, User::class);

        if (!empty($result))
            return $result;
        else
            return null;

    }


    /**
     * @param User $user
     */
    public function delete(User $user)
    {
        // TODO: Implement delete() method.
    }

    /**
     * Update the given user.
     * @param User $user
     * @return bool
     */
    public static function update(User $user)
    {

        if (empty($user->getPassword())) {

            $sql = "
            UPDATE users
            SET username = :un,
                first_name = :fn,
                last_name = :ln,
                role = :role
            WHERE id = :id
            ";

            $db = Database::get_instance();
            $statement = $db->prepare($sql);
            return $statement->execute([
                ':un' => $user->getUsername(),
                ':fn' => $user->getFirstName(),
                ':ln' => $user->getLastName(),
                ':role' => $user->getRole(),
                ':id' => $user->getId()
            ]);

        } else {
            $sql = "
            UPDATE users
            SET username = :un,
                first_name = :fn,
                last_name = :ln,
                role = :role,
                password_string = :ps
            WHERE id = :id
            ";

            $db = Database::get_instance();
            $statement = $db->prepare($sql);
            return $statement->execute([
                ':un' => $user->getUsername(),
                ':fn' => $user->getFirstName(),
                ':ln' => $user->getLastName(),
                ':role' => $user->getRole(),
                ':ps' => $user->generatePasswordString(),
                ':id' => $user->getId()
            ]);
        }


    }

    /**
     * @param User $user
     * @return bool
     */
    public static function save(User $user)
    {

        $sql = "
        INSERT INTO users(username, first_name, last_name, password_string, role) 
        VALUES(:un, :fn, :ln, :ps, :role)
        ";

        $db = Database::get_instance();
        $statement = $db->prepare($sql);
        return $statement->execute([
            ':un' => $user->getUsername(),
            ':fn' => $user->getFirstName(),
            ':ln' => $user->getLastName(),
            ':ps' => $user->generatePasswordString(),
            ':role' => $user->getRole(),
        ]);
    }

    /**
     * @param $username
     * @return User
     */
    public static function findByUsername($username): ?User
    {
        $db = Database::get_instance();
        $statement = $db->prepare("SELECT * FROM users WHERE username=?");
        $statement->execute([$username]);

        $result = $statement->fetchObject(User::class);

        if (!empty($result))
            return $result;
        else
            return null;
    }


}