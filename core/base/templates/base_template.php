<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        * {
            word-wrap: break-word;
        }
        html {
            position: relative;
            min-height: 100%;
        }
        body {
            margin-bottom: 60px;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <?php echo $template;
        if(!empty($scriptUrls)) {
            foreach ($scriptUrls as $url) { ?>
                <script src="<?php echo $url; ?>"></script>
            <?php }
        } ?>
    <footer class="footer">
        <div class="container">
            <p class="text-muted">Copyright (c) 2016 Copyright Holder All Rights Reserved.</p>
      </div>
    </footer>
    <?php if(!empty($script)) {
            echo '<script type="text/javascript">'.$script.'</script>';
        } ?>
</body>
</html>
