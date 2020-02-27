<?php

namespace App;

/**
 * Роутер приложения.
 */
class Router {

    protected static $_instance;

    function __construct() {
        $this->rules = include_once("rules.php");
    }

    public static function getInstance() {
        if(self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Анализ URL.
     */
    public function parseUrl() {
        $route = $_SERVER['REQUEST_URI'];
        if(array_key_exists($route, $this->rules)) {
            $ruleParts = explode('/', $this->rules[$route]);
            $moduleName = $ruleParts[0];
            $controllerName = 'Controller'.ucfirst($moduleName);
            $methodName = $ruleParts[1];
            if(class_exists($controllerName)) {
                $controller = new $controllerName();
                if(method_exists($controller, $methodName)) {
                    try {
                        $controller->$methodName();
                    }
                    catch(\Exception $e){
                        throw $e;
                    }
                }
                else{
                    $this->redirect('/404.html');
                }
            }
            else{
                $this->redirect('/404.html');
            }
        }
        else{
            $this->redirect('/404.html');
        }
    }

    /**
     * Редирект на новый адрес.
     *
     * @param $url - адрес редиректа.
     */
    public function redirect($url) {
        if(headers_sent() == false) {
            header('Location: '.$url, true, 301);
            exit();
        }
    }

}
