<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>PHR</title>
    <meta author="NB">
    <link href="<?php echo asset_url('/css/bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url('/css/main.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url('/css/menu.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url('/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo asset_url('/css/jquery.fancybox.css'); ?>" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo asset_url('/css/jquery.fancybox-thumbs.css'); ?>" type="text/css" media="screen" />
    <script src="<?php echo asset_url('/js/jquery-1.11.0.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo asset_url('/js/jquery.ext.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo asset_url('/js/jquery.mousewheel-3.0.6.pack.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset_url('/js/jquery.fancybox.pack.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset_url('/js/jquery.fancybox-media.js'); ?>"></script>
    
</head>
<body>
    <header>
        <?php
            require_once 'header.php';
        ?>
    </header>
    <section class="phr-container">
        <div class="phr-content">
            <div class="phr-left-content">
                <div class="main-container">

                    <?php if ($title) { ?>
                    <div class="c-map">
                        <ul class="noselect">
                            <?php foreach ($title as $item) {
                                echo $item;
                             } ?>
                        </ul>
                    </div>
                    <?php } ?>

                    <div class="main-content" id="printable">
                        <?php
                            echo $content;
                        ?>
                    </div>
                </div>
            </div>
            <div class="phr-right-content">
                <?php
                    require_once 'right_nav.php';
                ?>
            </div>
        </div>
    </section>
    <footer>
        <?php
            require_once 'footer.php';
        ?>
    </footer>
    <script src="<?php echo asset_url('/js/bootstrap.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo asset_url('/js/calendar.js'); ?>" type="text/javascript"></script>
    
    <script src="<?php echo asset_url('/js/gallery.js'); ?>" type="text/javascript"></script>
</body>
</html>