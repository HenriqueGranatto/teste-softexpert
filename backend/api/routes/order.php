<?php
    $router->get("/order/list", "Order@getOrderList");
    $router->post("/find/order", "Order@getOrder");
    $router->post("/order", "Order@postOrder");
    $router->put("/order", "Order@editProduct");
    $router->delete("/order", "Order@deleteOrder");
?>