<?php
    $router->get("/product/list", "Product@getProductList");
    $router->post("/find/product", "Product@getProduct");
    $router->post("/product", "Product@postProduct");
    $router->put("/product", "Product@putProduct");
    $router->delete("/product", "Product@deleteProduct");
?>