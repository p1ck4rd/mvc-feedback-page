<?php

/**
 * Модель модуля feedback.
 */
class ModelFeedback extends App\ModelBase {

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
            $query = "SELECT `author_name`, `author_email`, `text`, `picture`, DATE_FORMAT(`date`, '%d/%m/%Y %H:%i:%s') AS `date`, `changed` FROM message WHERE `allowed`='1' ORDER BY `$field`";
            if($direction == 'descending') {
                $query = $query.' DESC';
            }
            $db->query($query);
            $messages = $db->fetchAll();
            return $messages;
        }
    }

    /**
     * Добавтить отзыв.
     *
     * @param string $name - имя автора.
     * @param string $email - email автора.
     * @param string $message - текст отзыва.
     * @param array $file - информация о прикрепленном изображении.
     * @return bool результат добавления.
     */
    public function addMessage($name, $email, $message, $file=null) {
        $db = App\Core::getInstance()->database;
        $name = $db->realEscapeString($name);
        $email = $db->realEscapeString($email);
        $message = $db->realEscapeString($message);
        $date = date("Y-m-d H:i:s");
        if(preg_match('/.+@.+\..+/i', $email) && strlen($message) > 20 && strlen($message) <= 500) {
            if(isset($file)) {
                if($file['type'] == 'image/jpeg' || $file['type'] == 'image/gif' || $file['type'] == 'image/png') {
                    $extension = substr($file['type'], 6);
                    do {
                        $newFileName = md5(microtime().rand(0, 9999));
                        $newFilePath = '/images/'.$newFileName.'.'.$extension;
                    } while (file_exists($_SERVER['DOCUMENT_ROOT'].$newFilePath));
                    if(move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$newFilePath)) {
                        $this->checkImageSize($_SERVER['DOCUMENT_ROOT'].$newFilePath, $extension);
                        return $db->query("INSERT INTO message(`author_name`, `author_email`, `text`, `picture`, `date`) VALUES ('$name', '$email', '$message', '$newFilePath', '$date')");
                    }
                }
            }
            else
                return $db->query("INSERT INTO message(`author_name`, `author_email`, `text`, `date`) VALUES ('$name', '$email', '$message', '$date')");
        }
    }

    /**
     * Проверить и при необходимости изменить размер изображения.
     *
     * @param string $image - путь к изображению.
     * @param string $extension - расширение изображения.
     */
    private function checkImageSize($image, $extension) {
        $width = 320;
        $height = 240;
        list($imageWidth, $imageHeight) = getimagesize($image);
        if($imageWidth > $width || $imageHeight > $height) {
            $widthRatio = $width/$imageWidth;
            $heightRatio = $height/$imageHeight;
            if($widthRatio < $heightRatio) {
                $ratio = $widthRatio;
            }
            else {
                $ratio = $heightRatio;
            }
            $newWidth = $imageWidth * $ratio;
            $newHeight = $imageHeight * $ratio;
            $trueColor = imagecreatetruecolor($newWidth, $newHeight);
            switch ($extension) {
                case 'jpeg':
                    $source = imagecreatefromjpeg($image);
                    imagecopyresized($trueColor, $source, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
                    imagejpeg($trueColor, $image);
                    break;
                case 'png':
                    $source = imagecreatefrompng($image);
                    imagecopyresized($trueColor, $source, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
                    imagepng($trueColor, $image);
                    break;
                case 'gif':
                    $source = imagecreatefromgif($image);
                    imagecopyresized($trueColor, $source, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);
                    imagegif($trueColor, $image);
                    break;
            }
        }
    }

}
