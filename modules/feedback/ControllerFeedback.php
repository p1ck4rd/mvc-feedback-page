<?php

/**
 * Контроллер модуля feedback.
 */
class ControllerFeedback extends App\ControllerBase {

    function __construct() {
        $this->model = new ModelFeedback();
        $this->view = new ViewFeedback();
    }

    /**
     * Отображение страницы обратной связи.
     */
    public function show() {
        $messages = $this->model->getMessages();
        if(!empty($messages)) {
            $this->view->show($messages);
        }
        else{
            $this->view->show();
        }
    }

    /**
     * Добавить отзыв.
     */
    public function addMessage() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
                if(empty($_FILES['image']['name'])) {
                    $this->view->ajaxAnswer($this->model->addMessage($_POST['name'], $_POST['email'], $_POST['message']));
                }
                else {
                    $this->view->ajaxAnswer($this->model->addMessage($_POST['name'], $_POST['email'], $_POST['message'], $_FILES['image']));
                }
            }
        }
        else {
             App\Core::getInstance()->router->redirect('/404.html');
        }
    }

    /**
     * Сортировка отзывов.
     */
    public function sort() {
       if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
           if(isset($_POST['field']) && isset($_POST['direction'])) {
               $messages = $this->model->getMessages($_POST['field'], $_POST['direction']);
               if(!empty($messages)) {
                   $this->view->showOnlyMessages($messages);
               }
           }
       }
       else {
           App\Core::getInstance()->router->redirect('/404.html');
       }
    }
}
