<?php

/**
 * Представление модуля admin.
 */
class ViewAdmin extends App\ViewBase {

    /**
    * Представление отзывов.
    *
    * @param array $messages - массив с информацией об отзывах.
    */
    public function showOnlyMessages($messages=null) {
        ob_start();
        if(isset($messages)) {
            foreach ($messages as $message) {
                $messageId = $message['id'];
                $authorName = $message['author_name'];
                $authorEmail = $message['author_email'];
                $text = $message['text'];
                $picture = $message['picture'];
                $date = $message['date'];
                $allowed = $message['allowed'];
                $changed = $message['changed'];
                include 'templates/message.php';
            }
        }
        $messagesTemplate = ob_get_contents();
        ob_end_clean();
        echo $messagesTemplate;
    }

    /**
    * Представление панели администратора.
    *
    * @param array $messages - массив с информацией об отзывах.
    */
    public function show($messages=null) {
        $this->setTitle('Панель администратора');
        $this->addScript(file_get_contents(__DIR__.'/templates/js/admin.js'));
        ob_start();
        $this->showOnlyMessages($messages);
        $messages = ob_get_contents();
        ob_end_clean();
        ob_start();
        include_once 'templates/show_admin.html';
        $pageTemplate = ob_get_contents();
        ob_end_clean();
        $this->showWithBaseTemplate($pageTemplate);
    }

    /**
    * Представление формы аутентификации администратора.
    */
    public function showAuth() {
        $this->setTitle('Авторизация в панели администратора');
        ob_start();
        include_once 'templates/auth_admin.html';
        $pageTemplate = ob_get_contents();
        ob_end_clean();
        $this->showWithBaseTemplate($pageTemplate);
    }

}
