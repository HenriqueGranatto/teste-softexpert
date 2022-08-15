<?php
    require("/var/www/domain/Order/Model.php");
    require("/var/www/domain/Product/Product.php");

    class Order
    {
        public static function getOrderList()
        {
            try 
            {                
                return ModelOrder::getOrderList();
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao buscar a lista de pedidos porque: ".$e->getMessage());
            }
        }

        public static function getOrder($order)
        {
            try 
            {                
                $order = ModelOrder::getOrder($order["id"])[0];
                $products = ModelOrder::getOrderProducts($order["id"]);

                $response = [
                    "amount" => $order["amount"],
                    "total_tax" => $order["total_tax"],
                    "total_price" => $order["total_price"],
                    "timestamp" => $order["created"],
                    "products" => $products
                ];

                return $response;
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao buscar os dados do pedido porque: ".$e->getMessage());
            }
        }

        public static function postOrder($data)
        {
            try 
            {                
                $products = [];
                $order = ["amount" => 0, "total_tax" => 0, "total_price" => 0];

                foreach ($data["products"] as $key => $value) 
                {
                    $productInfo = Product::getProduct($value)[0];
                    $productInfo["amount"] = intval($value["amount"]);
                    $productInfo["total_tax"] = intval($value["amount"]) * (floatval($productInfo["tax"]) / 100);
                    $productInfo["total_price"] = intval($value["amount"]) * floatval($productInfo["price"]);

                    $order["amount"] += $productInfo["amount"];
                    $order["total_tax"] += $productInfo["total_tax"];
                    $order["total_price"] += $productInfo["total_price"];

                    array_push($products, $productInfo);
                }

                $order["id"] = intval(ModelOrder::postOrder($order));

                foreach ($products as $key => $value) 
                {
                    $products[$key]["market_order"] = $order["id"];
                    ModelOrder::postOrderProduct($products[$key]);
                }
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao cadastrar o pedido porque: ".$e->getMessage());
            }
        }

        public static function deleteOrder($data)
        {
            try 
            {                
                return ModelOrder::deleteOrder($data);
            } 
            catch (Exception $e) 
            {
                throw new Exception("Houve um problema ao deletar o pedido porque: ".$e->getMessage());
            }
        }
    }
?>