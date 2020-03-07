<?php


namespace Jman\Models;


use Jman\Core\Database;
use stdClass;

class Category
{

    public $id, $category_name;
    private $added_on, $updated_at;


    public function __construct()
    {
    }

    public function init($category_name)
    {
        $this->category_name = $category_name;
    }

    public function __toString()
    {
        return $this->category_name;
    }


    /**
     * @param $id
     * @return Category
     */
    public static function find($id)
    {
        $db = Database::get_instance();
        $statement = $db->prepare("SELECT * FROM categories WHERE id=?");
        $statement->execute([$id]);

        return $statement->fetchObject(Category::class);

    }


    public static function findAll($limit = 1000)
    {
        $db = Database::get_instance();

        $statement = $db->prepare("SELECT * FROM categories ORDER BY category_name LIMIT :limit_value");
        $statement->bindValue(":limit_value", $limit, \PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Category::class);
    }

    public function insert()
    {
        $db = Database::get_instance();

        $statement = $db->prepare("INSERT INTO categories(category_name) VALUE(?)");

        $result = $statement->execute([$this->category_name]);
        if ($result)
            return $db->lastInsertId();

        return false;
    }

    public function update()
    {
        $db = Database::get_instance();

        $statement = $db->prepare("UPDATE categories SET category_name=:cat_name WHERE id=:id");

        return $statement->execute([
            ':cat_name' => $this->category_name,
            ':id' => $this->id,
        ]);
    }

    public static function existing($category_name)
    {
        $db = Database::get_instance();
        $statement = $db->prepare("SELECT * FROM categories WHERE category_name=?");
        $statement->execute([$category_name]);

        return !empty($statement->fetchObject(Category::class)) ? true : false;
    }

    public function getItemsCount()
    {
        $db = Database::get_instance();
        $statement = $db->prepare("SELECT count(id) as total FROM items where category_id=?");
        $statement->execute([$this->id]);

        return ($statement->fetchObject(stdClass::class))->total;
    }

}