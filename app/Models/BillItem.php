<?php


namespace Jman\Models;


use Jman\Core\Database;
use PDO;

class BillItem
{
    public $bill_id, $item_id, $quantity, $price;

    public function insert()
    {

        $db = Database::get_instance();
        $statement = $db->prepare(
            "INSERT INTO bill_items(bill_id, item_id, quantity, price) 
                VALUES (:bill_id, :item_id, :q, :p)");


        return $statement->execute([
            ":bill_id" => $this->bill_id,
            ":item_id" => $this->item_id,
            ":q" => $this->quantity,
            ":p" => $this->price,
        ]);

    }

    /**
     * @param Bill $bill
     * @return BillItem[]
     */
    public static function findByBill(Bill $bill)
    {
        $db = Database::get_instance();
        $statement = $db->prepare("SELECT * FROM bill_items WHERE bill_id=?");

        $statement->execute([$bill->id]);

        return $statement->fetchAll(PDO::FETCH_CLASS, BillItem::class);
    }

    public function getItem()
    {
        return Item::find($this->item_id);
    }
}