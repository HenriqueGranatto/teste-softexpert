<?php
    require("/var/www/domain/Type/Type.php");

    class Controller
    {
        public static function getTypeList($request)
        {
            try 
            {
                $response = Type::getTypeList();
                return ["status" => 200, "message" => "Lista de tipos de produtos encontrada", "data" => $response];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }

        public static function getType($request)
        {
            try 
            {
                $response = Type::getType($request["REQUEST_BODY"]);
                return ["status" => 200, "message" => "Tipo encontrado", "data" => $response];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }

        public static function postType($request)
        {
            try 
            {
                $response = Type::postType($request["REQUEST_BODY"]);
                return ["status" => 201, "message" => "Tipo cadastrado", "data" => []];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }

        public static function putType($request)
        {
            try 
            {
                $response = Type::putType($request["REQUEST_BODY"]);
                return ["status" => 200, "message" => "Tipo alterado", "data" => $response];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }

        public static function deleteType($request)
        {
            try 
            {
                $response = Type::deleteType($request["REQUEST_BODY"]);
                return ["status" => 200, "message" => "Tipo deletado", "data" => $response];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }
    }
?>