<?php
    require 'no_cache.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>CMS PHR</title>
    <link href="<?php echo asset_url('/js/ext/resources/css/ext-all.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url('/css/ext-msg-icons.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo asset_url('/css/ad-main.css'); ?>" rel="stylesheet" type="text/css" />

    <script src="<?php echo asset_url('/js/jquery-1.11.0.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo asset_url('/js/jquery.ext.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo asset_url('/js/ext/ext-all.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo asset_url('/js/app/app.js'); ?>" type="text/javascript"></script>
    
    <script src="<?php echo asset_url('/js/ext/shared.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo asset_url('/js/tinymce/tiny_mce_src.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo asset_url('/js/TinyMCETextArea.js'); ?>" type="text/javascript"></script>
</head>
<body>
    <table width="100%">
        <tr>
            <td width="10%"></td>
            <td width="80%">
                <div>
                    <table width="100%">
                        <tr>
                            <td>
                                <?php
                                    echo $content;
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td width="10%"></td>
        </tr>
    </table>
</body>
</html>
