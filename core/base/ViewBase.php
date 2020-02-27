<?php

namespace App;

/**
 * Базовое представление.
 */
class ViewBase
{

    /**
     * @var string $title - заголовок страницы.
     * @var string $script - js-код страницы.
     * @var array $scriptUrls - адреса js-скриптов из внешних источников.
     */
    protected $title;
    protected $script;
    protected $scriptUrls = array();

    /**
     * Установить заголовок страницы.
     *
     * @param string $title - заголовок страницы.
     */
    protected function setTitle($title) {
        $this->title = $title;
    }

    /**
     *  Добавить js-код страницы.
     *
     * @param string $script - js-код страницы.
     */
    protected function addScript($script) {
        $this->script = $script;
    }

    /**
     *  Добавить js-скрипт из внешнего источника.
     *
     * @param string $scriptUrl - адрес js-скрипта из внешнего источника.
     */
    protected function addScriptUrl($scriptUrl) {
        array_push($this->scriptUrls, $scriptUrl);
    }

    /**
     *  Отобразить страницу.
     *
     * @param string $template - шаблон страницы.
     */
    protected function showWithBaseTemplate($template) {
        $title = $this->title;
        $script = $this->script;
        $scriptUrls = $this->scriptUrls;
        include_once('templates/base_template.php');
    }

}
