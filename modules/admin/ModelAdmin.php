<?php

/**
 * Модель модуля admin.
 */
class ModelAdmin extends App\ModelBase {

    /**
     * Авторизация администратора.
     * @return bool.
     */
    public function isAdmin() {
        if(isset($_SESSION['adminId'])) {
            return true;
        }
        return false;
    }

    /**
     * Получение отсортированного списка отзывов.
     *
     * @param string $field - поле сортировки.
     * @param string $direction - направление сортировки.
     * @return array отсортированный массив, содержащий информацию об отзывах.
     */
    public function getMessages($field='date', $direction='descending') {
        if(($field == 'author_name' || $field == 'author_email' || $field == 'date') && ($direction == 'ascending' || $direction == 'descending')){
            $db = App\Core::getInstance()->database;
            $query = "SELECT `id`, `author_name`, `author_email`, `text`, `picture`, DATE_FORMAT(`date`, '%d/%m/%Y %H:%i:%s') AS `date`, `changed`, `allowed` FROM message ORDER BY `$field`";
            if($direction == 'descending') {
                $query = $query.' DESC';
            }
            $db->query($query);
            $messages = $db->fetchAll();
            return $messages;
        }
    }

    /**
     * Изменение статуса отзыва.
     *
     * @param int $id - id отзыва.
     * @param bool $allowed - новый статус.
     */
    public function changeAllowed($id, $allowed) {
        $db = App\Core::getInstance()->database;
        $id = $db->realEscapeString($id);
        $allowed = $db->realEscapeString($allowed);
        if($allowed == 0 || $allowed == 1) {
            $db->query("SELECT * FROM message WHERE `id`='$id'");
            if(!empty($db->fetchArray())) {
                $db->query("UPDATE message SET `allowed`='$allowed' WHERE `id`='$id'");
            }
        }
    }

    /**
     * Изменение текста отзыва.
     *
     * @param int $id - id отзыва.
     * @param string $message - новый текст сообщения.
     */
    public function changeMessage($id, $message) {
        $db = App\Core::getInstance()->database;
        $id = $db->realEscapeString($id);
        $message = $db->realEscapeString($message);
        if(strlen($message) > 20 && strlen($message) <= 500) {
            $db->query("SELECT * FROM message WHERE `id`='$id'");
            if(!empty($db->fetchArray())) {
                $db->query("UPDATE message SET `text`='$message', `changed`='1' WHERE `id`='$id'");
            }
        }
    }

    /**
     * Аутентификация администратора.
     *
     * @param string $login - логин администратора.
     * @param string $pass - пароль администратора.
     * @return array 'success' - успешность операции; 'error' - ошибка.
     */
    public function authConfirm($login, $pass) {
        $db = App\Core::getInstance()->database;
        $login = $db->realEscapeString($login);
        $pass = $db->realEscapeString($pass);
        if($db->query("SELECT * FROM admin WHERE `login`='$login'")){
            $admin = $db->fetchArray();
            if($this->md5WithSalt($pass, $admin['salt']) == $admin['password']) {
                session_start();
                $_SESSION['adminId'] = $admin['id'];
                return true;
            }
        }
        return false;
    }

    /**
     * Прекратить сеанс работы в качестве администратора.
     */
    public function signOff() {
        unset($_SESSION['adminId']);
    }

    /**
     * Сгенерировать хэш пароля с солью.
     */
    private function md5WithSalt($pass, $salt) {
        return md5($pass.$salt);
    }

}
