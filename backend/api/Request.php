<?php
    class Request
    {
        private $Router;

        public function __construct($Router)
        {
            $this->Router = $Router;
            $body = empty(json_decode(file_get_contents('php://input'), true)) ? [] : json_decode(file_get_contents('php://input'), true);
            $this->data = array_merge($_SERVER, ["REQUEST_BODY" => $body]);
        }

        public function process()
        {
            foreach ($this->Router->endpoints as $endpoint) 
            {
                if($endpoint->method == $this->data["REQUEST_METHOD"] && $endpoint->url == $this->data["REQUEST_URI"])
                {
                    $controller = explode("@", $endpoint->controller);
                    require("/var/www/domain/{$controller[0]}/Controller.php");
                    return call_user_func(["Controller", $controller[1]], $this->data);
                }
            }
        }
    }
?>