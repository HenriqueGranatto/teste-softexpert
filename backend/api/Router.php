<?php
    class Router
    {
        public $endpoints;

        public function __construct()
        {
            $this->endpoints = [];
        }

        private function register($method, $url, $controller)
        {
            $endpoint = new stdClass();
            $endpoint->url = $url;
            $endpoint->method = $method;
            $endpoint->controller = $controller;   
            array_push($this->endpoints, $endpoint);
        }

        public function get(string $url, string $controller)
        {
            $this->register("GET", $url, $controller);
        }    

        public function post(string $url, string $controller)
        {
            $this->register("POST", $url, $controller);
        }    

        public function put(string $url, string $controller)
        {
            $this->register("PUT", $url, $controller);
        }    

        public function delete(string $url, string $controller)
        {
            $this->register("DELETE", $url, $controller);
        }    
    }
?>