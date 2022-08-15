<?php
    $router->get("/type/list", "Type@getTypeList");
    $router->post("/find/type", "Type@getType");
    $router->post("/type", "Type@postType");
    $router->put("/type", "Type@putType");
    $router->delete("/type", "Type@deleteType");
?>