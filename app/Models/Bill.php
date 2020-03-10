<?php


namespace Jman\Models;


use Jman\Core\Database;
use PDO;

class Bill
{
    public $id, $bill_date, $customer_name, $contact_number, $address, $bill_total;
    public $discount, $added_on, $updated_at;


    /**
     * @param int $limit
     * @return Bill[]
     */
    public static function findAll(int $limit = 1000)
    {
        $db = Database::get_instance();
        $statement = $db->prepare("SELECT * FROM bills order by bill_date DESC LIMIT :limit_val");
        $statement->bindValue(':limit_val', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS, Bill::class);
    }


    /**
     * @param $items
     * @return Bill
     */
    public function insert($items)
    {

        $db = Database::get_instance();

        try {
            $db->beginTransaction();

            $statement = $db->prepare(
                "INSERT INTO bills(bill_date, customer_name, contact_number, address, bill_total, discount) 
                VALUES (:b_date, :c_name, :c_number, :address, :b_total, :discount)");


            $statement->execute([
                ":b_date" => $this->bill_date,
                ":c_name" => $this->customer_name,
                ":c_number" => $this->contact_number,
                ":address" => $this->address,
                ":b_total" => $this->bill_total,
                ":discount" => $this->discount,
            ]);

            $bill_id = $db->lastInsertId();

            $bill_total = 0;

            foreach ($items as $item) {

                $billItem = new BillItem();
                $billItem->bill_id = $bill_id;
                $billItem->item_id = $item['id'];
                $billItem->price = $item['price'];
                $billItem->quantity = $item['quantity'];

                $billItem->insert();

                $item = Item::find($item['id']);
                $item->reduceQuantity($billItem->quantity);

                $bill_total += (float)$billItem->price;

            }


            $bill = Bill::find($bill_id);
            $bill->updateBillTotal($bill_total);

            $db->commit();

            return $bill;

        } catch (\PDOException $exception) {
            $db->rollBack();
            throw $exception;
        }

    }

    /**
     * @param $id
     * @return Bill
     */
    public static function find($id)
    {
        $db = Database::get_instance();
        $statement = $db->prepare("SELECT * FROM bills WHERE id=? LIMIT 1");

        $statement->execute([$id]);

        return $statement->fetchObject(Bill::class);
    }

    public function updateBillTotal($total)
    {
        $db = Database::get_instance();
        $statement = $db->prepare(
            "UPDATE bills SET                    
                    bill_total = :total
                WHERE id = :id;");


        return $statement->execute([
            ":id" => $this->id,
            ":total" => $total,
        ]);
    }

}