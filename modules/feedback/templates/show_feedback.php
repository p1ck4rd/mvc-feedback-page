<h1 class="h1 page-header text-center">Обратная связь</h1>
<div class="col-sm-2">
    <a href="/admin" class="btn btn-default">Панель администратора</a>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Форма обратной связи</h3>
                </div>
                <div class="panel-body">
                    <div class="alert alert-success hidden" id="send-successfully">
                        <strong>Отзыв отправлен!</strong> Он будет добавлен после проверки администратором.
                    </div>
                    <div class="alert alert-danger hidden" id="send-unsuccessfully">
                        <strong>Ошибка!</strong> Попробуйте отправить отзыв позже.
                    </div>
                    <div class="panel panel-default hidden" id="preview">
                        <div class="panel-heading">
                            <h3 class="panel-title">Предварительный просмотр</h3>
                        </div>
                        <div class="panel-body" id="preview-content">
                        </div>
                    </div>
                    <form method="post" id="new-message" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="name">Имя:</label>
                                    <input class="form-control" type="text" name="name" placeholder="Введите Ваше имя" minlength="2" maxlength="30" required="required">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group has-feedback">
                                    <label class="control-label" for="email">Email:</label>
                                    <input class="form-control" type="email" name="email" placeholder="Введите Ваш Email" maxlength="30" required="required">
                                </div>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label" for="message">Сообщение:</label>
                            <textarea class="form-control" name="message" rows="5" placeholder="Введите сообщение от 20 до 500 символов" minlength="20" maxlength="500" required="required"></textarea>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="file"></label>
                            <input type="file" name="image" accept="image/jpeg, image/gif, image/png" title="Добавить изображение">
                        </div>
                    </form>
                    <button type="button" class="btn btn-info" id="preview-btn" form="new-message">Предпросмотр сообщения</button>
                    <button type="button" name="add-message" class="btn btn-success pull-right" id="add-message-btn" form="new-message">Отправить сообщение</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-info">
                <div class="panel-body">
                    <label for="sort" class="control-label input-group">Сортировка сообщений</label>
                    <div name="sort">
                        <form id="sort">
                            <div class="btn-group form-group" data-toggle="buttons">
                                <label class="btn btn-default" name="field">
                                    <input name="field" value="author_name" type="radio">Автор
                                </label>
                                <label class="btn btn-default">
                                    <input name="field" value="author_email" type="radio">Email
                                </label>
                                <label class="btn btn-default active">
                                    <input name="field" value="date" type="radio" checked>Дата
                                </label>
                            </div>
                            <div class="btn-group form-group" data-toggle="buttons">
                                <label class="btn btn-default">
                                    <input name="direction" value="ascending" type="radio">По возрастанию
                                </label>
                                <label class="btn btn-default active">
                                        <input name="direction" value="descending" type="radio" checked>По убыванию
                                </label>
                            </div>
                        </form>
                        <button type="button" class="btn btn-default" id="sort-btn">Сортировать</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="messages">
    <?php echo $messages; ?>
</div>
