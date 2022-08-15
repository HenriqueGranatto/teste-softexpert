<?php
    require("/var/www/domain/Product/Product.php");

    class Controller
    {
        public static function getProductList($request)
        {
            try 
            {
                $response = Product::getProductList();
                return ["status" => 200, "message" => "Lista de produtos encontrada", "data" => $response];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }

        public static function getProduct($request)
        {
            try 
            {
                $response = Product::getProduct($request["REQUEST_BODY"]);
                return ["status" => 200, "message" => "Produto encontrado", "data" => $response];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }

        public static function postProduct($request)
        {
            try 
            {
                $response = Product::postProduct($request["REQUEST_BODY"]);
                return ["status" => 201, "message" => "Produto cadastrado", "data" => []];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }

        public static function putProduct($request)
        {
            try 
            {
                $response = Product::putProduct($request["REQUEST_BODY"]);
                return ["status" => 200, "message" => "Produto alterado", "data" => $response];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }

        public static function deleteProduct($request)
        {
            try 
            {
                $response = Product::deleteProduct($request["REQUEST_BODY"]);
                return ["status" => 200, "message" => "Produtos deletado", "data" => $response];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }
    }
?>