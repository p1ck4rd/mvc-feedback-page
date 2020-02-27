<div class="container" id="feedback-message">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <span id="author">
                            <?php echo $authorName.'('.$authorEmail.')'; ?>
                        </span>
                        <span class="pull-right" id="date">
                            <?php echo $date; ?>
                        </span>
                    </h3>
                </div>
                <div class="panel-body">
                    <span>
                        <?php echo $text; ?>
                    </span>
                    <?php
                    if($picture != '') {?>
                        <img class="img-rounded center-block" src="<?php  echo $picture; ?>">
                    <?php }?>
                </div>
                <?php if($changed) {?>
                    <div class="panel-footer">
                        <span class="text-info"><i>Сообщение было отредактировано администратором</i></span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
