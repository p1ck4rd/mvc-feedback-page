$(document).ready(function() {

    /**
     * Изменить статус отзыва.
     */
    $('body').delegate('button[name="allowed"]', 'click',  function() {
        var ajaxData = $(this).parent().serialize() + '&' + $(this).attr("name") + '=' + $(this).val() + '&' + $('#sort-form').serialize();
        $.ajax({
            type: 'post',
            url: '/admin/allowed',
            data: ajaxData,
            success: function(data) {
                var messages = $('#messages');
                messages.empty();
                messages.append(data);
            }
        });
    });

    /**
     * Отобразить поле редактирования отзыва.
     */
    $('body').delegate('button[name="edit"]', 'click',  function() {
        var span = $(this).parents('.panel').find('.panel-body > span');
        if(span[0]) {
            var text = span.html();
            var messageId = $(this).parent().find('input[name="message-id"]').val();
            span.replaceWith('<form><input type="hidden" name="message-id" value="' + messageId + '"><div class="form-group has-feedback"><textarea class="form-control" name="message" rows="5" placeholder="Введите сообщение от 20 до 500 символов" minlength="20" maxlength="500" required="required">' + text + '</textarea></div><button type="button" class="btn btn-primary pull-right" name="change">Изменить сообщение</button></form>');
        }
        else {
            var form = $(this).parents('.panel').find('.panel-body > form');
            var text = form.find('textarea').html();
            form.replaceWith('<span>' + text + '</span>');
        }
    });

    /**
     * Изменить отзыв.
     */
    $('body').delegate('button[name="change"]', 'click',  function() {
        var form = $(this).parent();
        var message = form.find('textarea');
        var formValidity = true;
        if(message[0].checkValidity() && message.val().length >= 20) {
            message.parent('div').removeClass('has-error');
            message.parent('div').addClass('has-success');
        }
        else {
            formValidity = false;
            message.parent('div').removeClass('has-success');
            message.parent('div').addClass('has-error');
        }
        if(formValidity) {
            var ajaxData = form.serialize();
            $.ajax({
                type: 'post',
                url: '/admin/change',
                data: ajaxData,
                success: function(data) {
                    var messages = $('#messages');
                    messages.empty();
                    messages.append(data);
                }
            });
        }
    });

    /**
     * Отсортировать отзывы.
     */
    $('#sort-btn').on('click', function() {
        var ajaxData = $('#sort-form').serialize();
        $.ajax({
            type: 'post',
            url: '/admin/sort',
            data: ajaxData,
            success: function(data) {
                var messages = $('#messages');
                messages.empty();
                messages.append(data);
            }
        });
    });

});
