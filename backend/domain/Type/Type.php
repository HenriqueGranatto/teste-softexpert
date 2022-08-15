<?php
    require("/var/www/domain/Type/Model.php");

    class Type
    {
        public static function getTypeList()
        {
            try 
            {                
                return Model::getTypeList();
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao buscar a lista de produtos porque: ".$e->getMessage());
            }
        }

        public static function getType($type)
        {
            try 
            {                
                return Model::getType($type["id"]);
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao buscar os dados do tipo de produto porque: ".$e->getMessage());
            }
        }

        public static function postType($data)
        {
            try 
            {                
                Model::postType($data);
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao buscar os dados do tipo de produto porque: ".$e->getMessage());
            }
        }

        public static function putType($data)
        {
            try 
            {                
                return Model::putType($data);
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao editar o tipo de produto porque: ".$e->getMessage());
            }
        }

        public static function deleteType($data)
        {
            try 
            {                
                return Model::deleteType($data);
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao deletar o tipo de produto porque: ".$e->getMessage());
            }
        }
    }
?>