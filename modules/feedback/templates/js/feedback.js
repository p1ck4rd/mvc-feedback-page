$(document).ready(function() {

    //Изменить внешний вид кнопки выбора файла.
    $('input[type=file]').bootstrapFileInput();

    /**
     * Изменить размер изображения в предварительном просмотре.
     */
    function resizeImage(image) {
        var width = 320;
        var height = 240;
        var imageWidth = image.width;
        var imageHeight = image.height;
        if(imageWidth > width || imageHeight > height) {
            var ratio;
            var widthRatio = width/imageWidth;
            var heightRatio = height/imageHeight;
            if(widthRatio < heightRatio) {
                ratio = widthRatio;
            }
            else {
                ratio = heightRatio;
            }
            newWidth = imageWidth * ratio;
            newHeight = imageHeight * ratio;
            image.width = newWidth;
            image.height = newHeight;
        }
    }

    /**
     * Отобразить предварительный просмотр.
     */
    $('#preview-btn').click(function() {
        var message = $('textarea[name="message"]').val();
        var image = $('input[name="image"]')[0].files[0];
        var preview = $('#preview');
        if(message) {
            var previewContent = $("#preview-content");
            previewContent.html(message);
            if(image) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    previewContent.append('<img class="img-rounded center-block" id="preview-image" '+'src='+e.target.result+'>');
                    $('#preview-image').load(
                        function() {
                            resizeImage(this);
                        }
                    );
                }
                reader.readAsDataURL(image);
            }
            preview.removeClass('hidden');
        }
        else {
            preview.addClass('hidden');
        }
    });

    /**
     * Отправить отзыв.
     */
    $('#add-message-btn').click(function() {
        var name = $('input[name="name"]');
        var email = $('input[name="email"]');
        var message = $('textarea[name="message"]');
        var formValidity = true;
        if(name[0].checkValidity() && name.val().length >=2) {
            name.parent('div').removeClass('has-error');
            name.parent('div').addClass('has-success');
        }
        else {
            formValidity = false;
            name.parent('div').removeClass('has-success');
            name.parent('div').addClass('has-error');
        }
        if(email[0].checkValidity()) {
            email.parent('div').removeClass('has-error');
            email.parent('div').addClass('has-success');
        }
        else {
            formValidity = false;
            email.parent('div').removeClass('has-success');
            email.parent('div').addClass('has-error');
        }
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
            var dataAjax = new FormData($('#new-message')[0]);
            $.ajax({
                type: 'post',
                url: '/add',
                processData: false,
                contentType: false,
                data: dataAjax,
                success: function(data) {
                    var successAlert = $('#send-successfully');
                    var unsuccessAlert = $('#send-unsuccessfully');
                    if(data) {
                        unsuccessAlert.addClass('hidden');
                        successAlert.removeClass('hidden');
                        $('#preview').addClass('hidden');
                        $(':input','#new-message').val('');
                        $('.file-input-name').remove();
                    }
                    else {
                        successAlert.addClass('hidden');
                        unsuccessAlert.removeClass('hidden');
                    }
                },
                error: function() {
                    $('#send-successfully').addClass('hidden');
                    $('#send-unsuccessfully').removeClass('hidden');
                }
            });
        }
    });

    /**
     * Отсортировать отзывы.
     */
    $('#sort-btn').click(function() {
        var dataAjax = $('#sort').serialize();
        $.ajax({
            type: 'post',
            url: '/feedback/sort',
            data: dataAjax,
            success: function(data) {
                var messages = $('#messages');
                messages.empty();
                messages.append(data);
            }
        });
    });
});
