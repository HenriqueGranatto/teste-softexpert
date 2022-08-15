<?php
    class ModelOrder
    {
        public static function getOrderList()
        {
            try 
            {
                $query = (new Database())
                ->select(["id", "amount", "total_tax", "total_price", "created"])
                ->from(["market_order"])
                ->where(["market_order.deleted" => 0])->execute()["data"];
                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }

        public static function getOrder($data)
        {
            try 
            {
                $query = (new Database())->select(["id", "amount", "total_tax", "total_price", "created"])->from(["market_order"])->where(["id" => $data])->execute()["data"];
                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }

        public static function getOrderProducts($data)
        {
            try 
            {
                $query = (new Database())
                ->select(["name", "type", "amount", "tax", "price", "total_tax", "total_price"])
                ->from(["market_order_products"])
                ->where(["market_order" => $data])->execute()["data"];
                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }

        public static function postOrder($data)
        {
            try 
            {
                $data["deleted"] = 0;
                $columns = array_keys($data);
                $values = array_values($data);
                $query = (new Database())->insertInto("market_order", $columns)->values($values)->execute()["insertedRowID"];

                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }

        public static function postOrderProduct($data)
        {
            try 
            {
                $columns = array_keys($data);
                $values = array_values($data);
                $query = (new Database())->insertInto("market_order_products", $columns)->values($values)->execute()["insertedRowID"];

                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }

        public static function deleteOrder($data)
        {
            try 
            {
                $query = (new Database())->update("market_order")->set(["deleted" => 1])->where(["id" => $data["id"]])->execute()["affectedRows"];
                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }
    }
?>