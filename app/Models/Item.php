<?php


namespace Jman\Models;


use Jman\Core\App;
use Jman\Core\Database;
use PDO;

class Item
{
    public $id, $item_name, $description, $stock_price, $quantity, $category_id, $weight, $gold_quality, $category_name;
    public $added_on, $updated_at;

    public $stock_price_string, $total_value_string;


    /**
     * @param $id
     * @return Item
     */
    public static function find(int $id)
    {
        $db = Database::get_instance();
        $statement = $db->prepare("SELECT * FROM items WHERE id=? LIMIT 1");

        $statement->execute([$id]);

        return $statement->fetchObject(Item::class);
    }


    /**
     * @param int $limit
     * @param bool $showEmpty
     * @return Item[]
     */
    public static function findAll(int $limit = 1000, $showEmpty = false)
    {
        $db = Database::get_instance();

        if ($showEmpty) {
            $statement = $db->prepare("SELECT * FROM items order by added_on LIMIT :limit_val");
        } else {
            $statement = $db->prepare("SELECT * FROM items WHERE quantity > 0 order by added_on LIMIT :limit_val");
        }

        $statement->bindValue(':limit_val', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, Item::class);
    }

    public function insert()
    {
        $db = Database::get_instance();
        $statement = $db->prepare(
            "INSERT INTO items(item_name, description, stock_price, quantity, category_id, weight, gold_quality) 
                VALUES (:item_name, :description, :stock_price, :quantity, :category_id, :weight, :gold_quality)");


        return $statement->execute([
            ":item_name" => $this->item_name,
            ":description" => $this->description,
            ":stock_price" => $this->stock_price,
            ":quantity" => $this->quantity,
            ":category_id" => $this->category_id,
            ":weight" => $this->weight,
            ":gold_quality" => $this->gold_quality,
        ]);
    }

    public function update()
    {
        $db = Database::get_instance();
        $statement = $db->prepare(
            "UPDATE items SET 
                    item_name = :item_name,
                    description = :description,
                    stock_price = :stock_price,
                    quantity = :quantity,
                    category_id = :category_id,
                    weight = :weight,
                    gold_quality = :gold_quality
                WHERE id = :id;");


        return $statement->execute([
            ":id" => $this->id,
            ":item_name" => $this->item_name,
            ":description" => $this->description,
            ":stock_price" => $this->stock_price,
            ":quantity" => $this->quantity,
            ":category_id" => $this->category_id,
            ":weight" => $this->weight,
            ":gold_quality" => $this->gold_quality,
        ]);
    }


    public function reduceQuantity($quantity)
    {
        $db = Database::get_instance();
        $statement = $db->prepare(
            "UPDATE items SET                    
                    quantity = :quantity
                WHERE id = :id;");


        return $statement->execute([
            ":id" => $this->id,
            ":quantity" => $this->quantity - $quantity,
        ]);
    }

    /**
     * @param Category $category
     * @param bool $showEmpty
     * @return Item[]
     */
    public static function getItemsByCategory(Category $category, $showEmpty = false)
    {
        $db = Database::get_instance();
        if($showEmpty){
            $statement = $db->prepare("SELECT * FROM items WHERE category_id=:category_id order by added_on");
        }else{
            $statement = $db->prepare("SELECT * FROM items WHERE category_id=:category_id AND quantity > 0 order by added_on");
        }
        $statement->execute([':category_id' => $category->id]);

        return $statement->fetchAll(PDO::FETCH_CLASS, Item::class);
    }

    /**
     * @param $keyword
     * @param bool $showEmpty
     * @param int $limit
     * @return Item[]
     */
    public static function search($keyword, $showEmpty = false, $limit = 100)
    {
        $db = Database::get_instance();

        if($showEmpty){
            $statement = $db->prepare("SELECT * FROM items WHERE (item_name LIKE :key OR description LIKE :key)  order by added_on LIMIT :limit_val");
        }else{
            $statement = $db->prepare("SELECT * FROM items WHERE (item_name LIKE :key OR description LIKE :key) AND quantity > 0 order by added_on LIMIT :limit_val");
        }


        $statement->bindValue(':limit_val', $limit, PDO::PARAM_INT);
        $statement->bindValue(':key', "%" . $keyword . "%");
        $statement->execute();

        /** @var Item[] $result */
        $result = $statement->fetchAll(PDO::FETCH_CLASS, Item::class);


        return $result;

    }

    public function getStockPriceString()
    {
        return App::toCurrencyString($this->stock_price);
    }

    public function getTotalValue()
    {
        return $this->stock_price * $this->quantity;
    }

    public function getTotalValueString()
    {
        return App::toCurrencyString($this->getTotalValue());
    }

    public function getCategory()
    {
        return Category::find($this->category_id);
    }

    public function getAddedOn()
    {
        return date('Y-m-d g:i:s a', strtotime($this->added_on));
    }

    public function getUpdatedAt()
    {
        return date('Y-m-d g:i:s a', strtotime($this->updated_at));
    }

}