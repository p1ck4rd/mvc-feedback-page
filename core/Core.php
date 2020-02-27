<?php

namespace App;

/**
 * Ядро приложения.
 */
class Core {

    protected static $_instance;

    /**
     * @var array $config - конфигурация ядра.
     * @var object $router - роутер приложения.
     * @var object $database - компонент для работы с базой данных.
     */
    private $config;
    public $router;
    public $database;

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        $this->config = include_once('config.php');
        spl_autoload_register(function($className) {
            $this->autoload($className);
        });
        $this->router = Router::getInstance();
        $this->database = Database::getInstance();
    }

    /**
     * Автоматическая загрузка классов.
     *
     * @param string $className - имя класса.
     */
    private function autoload($className) {
        $parts = explode('\\', $className);
        $className = end($parts);
        foreach($this->config['autoloadPathArray'] as $path) {
            $currentPath = $this->config['root'].'/'.$path;
            $filePath = $currentPath.'/'.$className.'.php';
            if(file_exists($filePath)) {
                require_once($filePath);
            }
            else {
                $dirIterator = new \DirectoryIterator($currentPath);
                foreach($dirIterator as $fileInfo) {
                    if(!$fileInfo->isDot() && $fileInfo->isDir()) {
                        $filePath = $currentPath.'/'.$fileInfo->getFileName().'/'.$className.'.php';
                        if(file_exists($filePath)) {
                            require_once $filePath;
                        }
                    }
                }
            }
        }
    }

}
