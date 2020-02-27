<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span><?php echo $authorName.'('.$authorEmail.')'; ?></span>
                        <span class="pull-right"><?php echo $date; ?></span>
                    </h3>
                </div>
                <div class="panel-body">
                    <span><?php echo $text; ?></span>
                    <?php
                    if($picture != '') {?>
                        <img class="img-rounded center-block" src="<?php  echo $picture; ?>">
                    <?php }?>
                </div>
                <div class="panel-footer">
                    <?php if($changed) {?>
                        <div class="form-group">
                            <span class="text-info"><i>Сообщение было отредактировано администратором</i></span>
                        </div>
                    <?php } ?>
                    <button class="btn btn-warning" name="edit">Редактировать отзыв</button>
                    <form class="pull-right">
                        <input type="hidden" name="message-id" value="<?php echo $messageId; ?>">
                        <?php switch($allowed) {
                        case '0': ?>
                        <button class="btn btn-success" type="button" name="allowed" value="1">Принять отзыв</button>
                        <button class="btn btn-danger"  type="button" disabled="disabled">Отзыв отклонен</button>
                        <?php break; ?>
                        <?php case '1': ?>
                        <button class="btn btn-success" type="button" disabled="disabled">Отзыв принят</button>
                        <button class="btn btn-danger" type="button" name="allowed" value="0">Отклонить отзыв</button>
                        <?php break; ?>
                        <?php default: ?>
                        <button class="btn btn-success" type="button" name="allowed" value="1">Принять отзыв</button>
                        <button class="btn btn-danger" type="button" name="allowed" value="0">Отклонить отзыв</button>
                        <?php break; } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
