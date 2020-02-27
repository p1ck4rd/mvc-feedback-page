<?php

/**
 * Представление модуля feedback.
 */
class ViewFeedback extends App\ViewBase {

    /**
    * Представление отзывов.
    *
    * @param array $messages - массив с информацией об отзывах.
    */
    public function showOnlyMessages($messages=null) {
        ob_start();
        if(isset($messages)) {
            foreach ($messages as $message) {
                $authorName = $message['author_name'];
                $authorEmail = $message['author_email'];
                $text = $message['text'];
                $picture = $message['picture'];
                $date = $message['date'];
                $changed = $message['changed'];
                include 'templates/message.php';
            }
        }
        $messagesTemplate = ob_get_contents();
        ob_end_clean();
        echo $messagesTemplate;
    }

    /**
    * Представление страницы обратной связи.
    *
    * @param array $messages - массив с информацией об отзывах.
    */
    public function show($messages = null) {
        $this->setTitle('Страница обратной связи');
        $this->addScriptUrl('http://google-code-prettify.googlecode.com/svn/trunk/src/prettify.js');
        $this->addScriptUrl('http://www.gregpike.net/demos/bootstrap-file-input/bootstrap.file-input.js');
        $this->addScript(file_get_contents(__DIR__.'/templates/js/feedback.js'));
        ob_start();
        $this->showOnlyMessages($messages);
        $messages = ob_get_contents();
        ob_end_clean();
        ob_start();
        include_once 'templates/show_feedback.php';
        $pageTemplate = ob_get_contents();
        ob_end_clean();
        $this->showWithBaseTemplate($pageTemplate);
    }

    /**
    * Передача результата ajax-запроса.
    *
    * @param string $answer - результата ajax-запроса
    */
    public function ajaxAnswer($answer) {
        echo $answer;
    }

}
