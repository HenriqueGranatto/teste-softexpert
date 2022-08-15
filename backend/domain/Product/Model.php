<?php
    require("/var/www/database/Database.php");

    class Model
    {
        public static function getProductList()
        {
            try 
            {
                $query = (new Database())
                ->select(["market_product.id" => "id", "market_product.name" => "name", "market_product_type.name" => "type", "market_product.price" => "price", "market_product_type.tax" => "tax"])
                ->from(["market_product", "market_product_type"])
                ->where(["market_product_type.id" => "market_product.type", "market_product.deleted" => 0])->execute()["data"];
                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }

        public static function getProduct($id)
        {
            try 
            {
                $query = (new Database())
                ->select(["market_product.id" => "id", "market_product.name" => "name", "market_product_type.name" => "type", "market_product.price" => "price", "market_product_type.tax" => "tax"])
                ->from(["market_product", "market_product_type"])
                ->where(["market_product_type.id" => "market_product.type", "market_product.id" => $id])->execute()["data"];
                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }

        public static function postProduct($data)
        {
            try 
            {
                $data["deleted"] = 0;
                $columns = array_keys($data);
                $values = array_values($data);
                $query = (new Database())->insertInto("market_product", $columns)->values($values)->execute()["insertedRowID"];

                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }

        public static function putProduct($data)
        {
            try 
            {
                unset($data["deleted"]);
                $query = (new Database())->update("market_product")->set($data)->where(["id" => $data["id"]])->execute()["affectedRows"];
                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }

        public static function deleteProduct($data)
        {
            try 
            {
                $query = (new Database())->update("market_product")->set(["deleted" => 1])->where(["id" => $data["id"]])->execute()["affectedRows"];
                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }
    }
?>