<?php

namespace App;

/**
 * Компонент для работы с БД.
 */
class Database {
    protected static $_instance;

    /**
     * @var string $dbServer - адрес сервера БД.
     * @var string $dbLogin - логин сервера БД.
     * @var string $dbPass - пароль сервера БД.
     * @var string $dbName - имя БД.
     * @var resource $link - соединение MySQL.
     * @var mixed $result - результат последнего запроса.
     */
    private $dbServer;
    private $dbLogin;
    private $dbPass;
    private $dbName;
    private $link;
    private $result;

    public static function getInstance() {
        if(self::$_instance == null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        $config = include('config.php');
        $this->dbServer = $config['server'];
        $this->dbLogin = $config['login'];
        $this->dbPass = $config['pass'];
        $this->dbName = $config['name'];
        $this->connect();
    }

    /**
     * Подключение к БД.
     */
    private function connect() {
        $this->link = mysqli_connect($this->dbServer, $this->dbLogin, $this->dbPass, $this->dbName)
            or die('Нет подключения');
        mysqli_set_charset($this->link, 'utf8');
    }

    /**
     * Выполнить запрос к БД.
     *
     * @param string $sql - запрос.
     */
    public function query($sql) {
        $result = mysqli_query($this->link, $sql);
        if($result == false) {
            throw new \Exception('Ошибка при работе с базой данных: '.mysqli_error($this->link));
        } else {
            $this->result = $result;
        }
        return $result;
    }

    /**
     * Обрабатка всех строк результата запроса.
     *
     * @return array ассоциативный массив.
     */
    public function fetchAll() {
        return mysqli_fetch_all($this->result, MYSQLI_ASSOC);
    }

    /**
     * Обрабатка ряда результата запроса.
     *
     * @return array ассоциативный массив.
     */
    public function fetchArray() {
        return mysqli_fetch_array($this->result, MYSQLI_ASSOC);
    }

    /**
     * Экранирование спецсимволов в строке.
     *
     * @param string $string - строка.
     * @return string строка с экранированными спецсимволами.
     */
    public function realEscapeString($string) {
        return mysqli_real_escape_string($this->link, $string);
    }
}
