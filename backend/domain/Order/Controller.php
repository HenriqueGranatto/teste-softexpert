<?php
    require("/var/www/domain/Order/Order.php");

    class Controller
    {
        public static function getOrderList($request)
        {
            try 
            {
                $response = Order::getOrderList();
                return ["status" => 200, "message" => "Lista de pedidos encontrada", "data" => $response];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }

        public static function getOrder($request)
        {
            try 
            {
                $response = Order::getOrder($request["REQUEST_BODY"]);
                return ["status" => 200, "message" => "Pedido encontrado", "data" => $response];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }

        public static function postOrder($request)
        {
            try 
            {
                $response = Order::postOrder($request["REQUEST_BODY"]);
                return ["status" => 201, "message" => "Pedido cadastrado", "data" => []];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }

        public static function deleteOrder($request)
        {
            try 
            {
                $response = Order::deleteOrder($request["REQUEST_BODY"]);
                return ["status" => 200, "message" => "Pedido deletado", "data" => $response];
            } 
            catch (Exception $e) 
            {
                return ["status" => 400, "message" => "Houve um problema ao processar a requisição", "data" => ""];
            }
        }
    }
?>