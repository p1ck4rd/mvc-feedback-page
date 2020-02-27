<?php

/**
 * Контроллер модуля admin.
 */
class ControllerAdmin extends App\ControllerBase
{

    function __construct() {
         $this->model = new ModelAdmin();
         $this->view = new ViewAdmin();
    }

    /**
     * Отображение панели администратора.
     */
    public function show() {
        if($this->model->isAdmin()) {
            $messages = $this->model->getMessages();
            if(!empty($messages)) {
                $this->view->show($messages);
            }
            else {
                $this->view->show();
            }
        }
        else {
            App\Core::getInstance()->router->redirect('/admin/auth');
        }
    }

    /**
    * Изменение статуса отзыва.
    */
    public function changeAllowed() {
        $router = App\Core::getInstance()->router;
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if($this->model->isAdmin()) {
                if(isset($_POST['allowed']) && isset($_POST['message-id']) &&  isset($_POST['field']) && isset($_POST['direction'])){
                    $this->model->changeAllowed($_POST['message-id'], $_POST['allowed']);
                    $this->view->showOnlyMessages($this->model->getMessages());
                }
            }
            else {
                $router->redirect('/404.html');
            }
        }
        else {
            $router->redirect('/404.html');
        }
    }

    /**
     * Изменение текста отзыва.
     */
    public function changeMessage() {
        $router = App\Core::getInstance()->router;
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if($this->model->isAdmin()) {
                if(isset($_POST['message-id']) && isset($_POST['message'])) {
                    $this->model->changeMessage($_POST['message-id'], $_POST['message']);
                    $this->view->showOnlyMessages($this->model->getMessages());
                }
            }
            else {
                $router->redirect('/404.html');
            }
        }
        else {
            $router->redirect('/404.html');
        }
    }

    /**
     * Сортировка отзывов.
     */
    public function sort() {
       if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
           if(isset($_POST['field']) && isset($_POST['direction'])) {
               $this->view->showOnlyMessages($this->model->getMessages($_POST['field'], $_POST['direction']));
           }
       }
       else {
           App\Core::getInstance()->router->redirect('/404.html');
       }
    }

    /**
    * Отображение формы аутентификации администратора.
    */
    public function showAuth() {
        if(!$this->model->isAdmin()) {
            $this->view->showAuth();
        }
        else {
            App\Core::getInstance()->router->redirect('/404.html');
        }
    }

    /**
     * Подтверждение аутентификации администратора.
     */
    public function authConfirm() {
        $router = App\Core::getInstance()->router;
        if(isset($_POST['admin-auth'])){
            if(isset($_POST['login']) && isset($_POST['password'])){
                if($this->model->authConfirm($_POST['login'], $_POST['password'])) {
                    $router->redirect('/admin');
                }
                else {
                    $router->redirect('/admin/auth');
                }
            }
            else{
                throw new Exception("Отсутствует поле");
            }
        }
        else{
            $router->redirect('/404.html');
        }
    }

    /**
    * Прекратить сеанс работы в качестве администратора.
    */
    public function signOff() {
        $router = App\Core::getInstance()->router;
        if($this->model->isAdmin()) {
            $this->model->signOff();
            $router->redirect('/admin/auth');
        }
        else {
            $router->redirect('/404.html');
        }
    }

}
