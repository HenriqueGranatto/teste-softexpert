<?php
require("/var/www/api/Router.php");
require("/var/www/api/Request.php");

try 
{
    $router = new Router();

    $files = glob(__DIR__ . '/api/routes/*.php');
        
    foreach ($files as $file) 
    {
        require_once $file;
    }
    
    $request = new Request($router);
    $response = $request->process();

    echo json_encode($response, true, JSON_UNESCAPED_UNICODE);
} 
catch (Error $e) 
{
    
    http_response_code(500);
    echo json_encode(["message" => "Houve um problema com o servidor", "data" => ""], true, JSON_UNESCAPED_UNICODE);
}