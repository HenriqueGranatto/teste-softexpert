<?php
    require("/var/www/database/Database.php");

    class Model
    {
        public static function getTypeList()
        {
            try 
            {
                $query = (new Database())->select(["id", "name", "tax"])->from("market_product_type")->where(["deleted" => 0])->execute()["data"];
                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }

        public static function getType($id)
        {
            try 
            {
                $query = (new Database())->select(["id", "name", "tax"])->from("market_product_type")->where(["id" => $id])->execute()["data"];
                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }

        public static function postType($data)
        {
            try 
            {
                $data["deleted"] = 0;
                $columns = array_keys($data);
                $values = array_values($data);
                $query = (new Database())->insertInto("market_product_type", $columns)->values($values)->execute()["insertedRowID"];

                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }

        public static function putType($data)
        {
            try 
            {
                unset($data["deleted"]);
                $query = (new Database())->update("market_product_type")->set($data)->where(["id" => $data["id"]])->execute()["affectedRows"];
                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }

        public static function deleteType($data)
        {
            try 
            {
                $query = (new Database())->update("market_product_type")->set(["deleted" => 1])->where(["id" => $data["id"]])->execute()["affectedRows"];
                return $query;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema com o ORM porque: ".$e->getMessage());
            }
        }
    }
?>