<?php
    require("/var/www/domain/Product/Model.php");

    class Product
    {
        public static function getProductList()
        {
            try 
            {                
                return Model::getProductList();
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao buscar a lista de produtos porque: ".$e->getMessage());
            }
        }

        public static function getProduct($product)
        {
            try 
            {                
                return Model::getProduct($product["id"]);
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao buscar os dados do produto porque: ".$e->getMessage());
            }
        }

        public static function postProduct($data)
        {
            try 
            {                
                Model::postProduct($data);
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao cadastrar o produto porque: ".$e->getMessage());
            }
        }

        public static function putProduct($data)
        {
            try 
            {                
                return Model::putProduct($data);
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao editar os dados do produto porque: ".$e->getMessage());
            }
        }

        public static function deleteProduct($data)
        {
            try 
            {                
                return Model::deleteProduct($data);
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao deletar o produto porque: ".$e->getMessage());
            }
        }
    }
?>